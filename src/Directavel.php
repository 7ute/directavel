<?php

namespace SevenUte\Directavel;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use SevenUte\Directavel\Exceptions\DirectavelMissingAdminUser;
use SevenUte\Directavel\Exceptions\DirectavelStorageMissingException;

class Directavel
{
    const CSS_SPACING = '    ';

    /** @var string|null */
    public $logo_id = null;

    /** @var int|null */
    public $admin_id = null;

    /** @var DirectavelTailwindColors */
    public $tailwind_palette = null;

    public function __construct()
    {
        if (file_exists(base_path(config('directavel.logo_path')))) {
            $disk = config('directavel.filesystem');
            $filesystem = config("filesystems.disks.{$disk}");
            if (!$filesystem) {
                throw new DirectavelStorageMissingException();
            }
            $this->logo_id = (config('directavel.logo_id') ?? (string) Str::uuid());
        } else {
            $this->logo_id = null;
        }
        $this->loadCurrentAdminId();
    }

    public function clearCache()
    {
        $directus_endpoint = config('directavel.internal_endpoint');
        $url = "{$directus_endpoint}/utils/cache/clear";
        $res = Http::withToken(config('directavel.admin_token'))->post($url);
        if ($res->status() != 200) {
            Log::error("Emptying directus cache failed.", ['status' => $res->status(), 'endpoint' => $directus_endpoint]);
            return $res;
        }
        return true;
    }

    public function loadCurrentAdminId()
    {
        $this->admin_id = optional(DB::table('directus_users')
            ->where('email', config('directavel.admin_user'))
            ->first('id'))
            ->id;
        if (!$this->admin_id) {
            throw new DirectavelMissingAdminUser();
        }
    }

    public function updateProjectAdmin()
    {
        DB::table('directus_users')
            ->where('id', $this->admin_id)
            ->update([
                'token' => config('directavel.admin_token'),
                'theme' => 'light',
            ]);
        return $this;
    }

    public function updateProjectLogo()
    {
        if (!$this->logo_id) {
            return $this;
        }
        if (!$this->tailwind_palette) {
            $this->loadTailwindThemeColors();
        }
        
        $logo_path = config('directavel.logo_path');
        $logo_color = $this->tailwind_palette->colors['700'];
        $logo_svg = file_get_contents(base_path($logo_path));
        $logo_svg = preg_replace('~fill=["\'][#a-fA-F0-9]+["\']~uim', sprintf('fill="%s"', $logo_color), $logo_svg);
        $size = strlen($logo_svg);

        Storage::disk(config('directavel.filesystem'))
            ->put(config('directavel.logo_name'), $logo_svg);

        DB::table('directus_files')
            ->insertOrIgnore([
                'id' => $this->logo_id,
                'storage' => config('directavel.logo_storage'),
                'filename_disk' => config('directavel.logo_name'),
                'filename_download' => config('directavel.logo_name'),
                'title' => config('directavel.logo_title'),
                'type' => config('directavel.logo_type'),
                'uploaded_by' => $this->admin_id,
                'uploaded_on' => now()->format('Y-m-d H:i:s'),
                'modified_on' => now()->format('Y-m-d H:i:s'),
                'filesize' => $size,
            ]);
        return $this;
    }

    public function updateProjectPresets()
    {
        $user_presets = collect(DB::table('directus_presets')->whereNotNull('user')->get())
            ->map(fn ($line) => collect($line)->except('id')->toArray());
        $presets = include config('directavel.presets_path', database_path('directus/presets.php'));
        DB::table('directus_presets')->whereNull('user')->truncate();
        DB::table('directus_presets')->insert($presets);
        DB::table('directus_presets')->insert($user_presets->toArray());
        return $this;
    }

    public function updateThemeCss()
    {
        if (!$this->tailwind_palette) {
            $this->loadTailwindThemeColors();
        }
        $color_name = Str::slug(config('directavel.tailwind_directus_color_name'));
        $css_colors = $this->tailwind_palette->colors->map(fn ($color, $key)  => (static::CSS_SPACING . "--{$color_name}-{$key}: {$color};"))->join(PHP_EOL);
        $project_color = $this->tailwind_palette->colors['400'];
        $settings_id = optional(DB::table('directus_settings')->first())->id;
        $custom_css = collect([
            ":root {",
            $css_colors,
            static::CSS_SPACING . "--v-progress-linear-transition: .25s !important;",
            static::CSS_SPACING . "--v-progress-circular-transition: .25s !important;",
            "}",
            "* {",
            static::CSS_SPACING . "--primary-alt: var(--{$color_name}-300) !important;",
            static::CSS_SPACING . "--primary-10: var(--{$color_name}-100) !important;",
            static::CSS_SPACING . "--primary-25: var(--{$color_name}-200) !important;",
            static::CSS_SPACING . "--primary-50: var(--{$color_name}-500) !important;",
            static::CSS_SPACING . "--primary-75: var(--{$color_name}-700) !important;",
            static::CSS_SPACING . "--primary-90: var(--{$color_name}-900) !important;",
            static::CSS_SPACING . "--primary: var(--{$color_name}-400) !important;",
            static::CSS_SPACING . "--primary-110: var(--{$color_name}-100) !important;",
            static::CSS_SPACING . "--primary-125: var(--{$color_name}-200) !important;",
            static::CSS_SPACING . "--primary-150: var(--{$color_name}-500) !important;",
            static::CSS_SPACING . "--primary-175: var(--{$color_name}-700) !important;",
            static::CSS_SPACING . "--primary-190: var(--{$color_name}-900) !important;",
            "}",
            ".private-view .content-wrapper { height: 100% !important; }",
            ".mapboxgl-ctrl-group button { color: inherit; }",
            ".module-nav-content > .nav > .v-divider,",
            ".module-nav-content > .nav > .v-divider ~ a {",
            static::CSS_SPACING . "display: none !important;",
            "}",
        ])->join(PHP_EOL);

        Schema::disableForeignKeyConstraints();
        DB::table('directus_settings')
            ->updateOrInsert([
                'id' => $settings_id,
            ], [
                'project_name' => config('directavel.app_name'),
                'project_color' => $project_color,
                'project_logo' => $this->logo_id,
                'custom_css' => $custom_css,
                'default_language' => config('directavel.language'),
            ]);
        Schema::enableForeignKeyConstraints();

        return $this;
    }

    public function loadTailwindThemeColors()
    {
        if (!config('directavel.tailwind_palette_file') || !file_exists(base_path(config('directavel.tailwind_palette_file')))) {
            $this->tailwind_palette = (object) [
                'name' => 'default',
                'colors' => collect(config('directavel.tailwind_palette', [])),
            ];
            return $this;
        }

        $tailwind_color_name = preg_quote(Str::slug(config('directavel.tailwind_directus_color_name')), '~');
        $tailwind_config = file_get_contents(base_path(config('directavel.tailwind_config_file')));
        $tailwind_palettes = file_get_contents(base_path(config('directavel.tailwind_palette_file')));

        $matches = [];
        preg_match('~^[\s\t]+' . $tailwind_color_name . ':\s*palettes(?:\[["\']|\.)?([a-z0-9_-]+)(?:["\']\]|.)?~mui', $tailwind_config, $matches);
        $accent_key = $matches[1] ?? null;

        $matches = [];
        preg_match("~'?{$accent_key}'?:\s*{([^}]+)}~mui", $tailwind_palettes, $matches);
        $accent_color_list = $matches[1] ?? null;

        $matches = [];
        preg_match_all("~[\"']?([0-9]+)[\"']?:\s[\"']([#a-zA-Z0-9]+)[\"'],?~mui", $accent_color_list, $matches, PREG_SET_ORDER);
        $accent_colors = collect($matches)->mapWithKeys(fn ($match) => ["{$match[1]}" => $match[2]]);

        $this->tailwind_palette = (object) [
            'name' => $accent_key,
            'colors' => $accent_colors,
        ];
        return $this;
    }

    public function synchronizeDatabase()
    {
        $structures = static::getStructure();
        $models = config('directavel.models');

        Schema::disableForeignKeyConstraints();
        $wipeable_tables = [
            'activity',
            'collections',
            'fields',
            'relations',
            'revisions',
        ];

        foreach ($wipeable_tables as $wipeable) {
            if (config("directavel.wipe.{$wipeable}")) {
                $models[$wipeable]::query()->truncate();
            }
        }

        foreach ($structures as $table => $structure) {
            $collection = ['collection' => $table];
            if (is_array($structure['attributes'] ?? null)) {
                $collection = [...$collection, ...$structure['attributes']];
            }
            $models['collections']::firstOrCreate([
                'collection' => $collection['collection'],
            ], $collection);

            foreach (($structure['fields'] ?? []) as $field_name => $field) {
                $attributes = [
                    'collection' => $table,
                ];
                if (!is_string($field_name)) {
                    $attributes['field'] = $field;
                    $attributes['interface'] = $models['fields']::INTERFACE_INPUT;
                } else {
                    $attributes['field'] = $field_name;
                    if (is_string($field)) {
                        $attributes['interface'] = $field;
                    } else {
                        $attributes['interface'] = $models['fields']::INTERFACE_INPUT;
                        if (is_array($field['relation'] ?? null)) {
                            $relation = [
                                'many_collection' => $table,
                                ...$field['relation'],
                            ];
                            $models['relations']::create($relation);
                            unset($field['relation']);
                        }
                        $attributes = [...$attributes, ...$field];
                    }
                }
                $models['fields']::create($attributes);
            }

            foreach (($structure['relations'] ?? []) as $field_name => $relation) {
                $models['relations']::create($relation);
            }
        }

        Schema::enableForeignKeyConstraints();

        $structures = null;
        return $this;
    }

    public function getStructure()
    {
        $collections = [];
        $files = glob(base_path(config('directavel.collections_path_pattern', 'database/directus/collections/*.php')));
        foreach ($files as $file) {
            $table = basename($file, '.php');
            $collections[$table] = include $file;
        }
        return $collections;
    }
}
