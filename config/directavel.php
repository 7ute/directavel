<?php

return [
    'app_name' => env('APP_NAME', 'Directus'),
    'admin_user' => env('DIRECTUS_ADMIN_USER', 'admin@example.org'),
    'admin_token' => env('DIRECTUS_ADMIN_TOKEN', '00000000000000000000000000000000'), // 32 chars alphanumeric string
    'language' => env('DIRECTUS_ADMIN_LOCALE', 'en-US'),

    /**
     * Used to trigger the cache cleanup routine.
     * Can be different from your exposed url
     * if Directus runs inside Docker/Sail.
     */
    'internal_endpoint' => env('DIRECTUS_INTERNAL_ENDPOINT', 'http://localhost:8055'),

    /**
     * Media filesystem shared with directus.
     */
    'filesystem' => env('DIRECTUS_FILESYSTEM', 'directus'),
    
    /**
     * Directus database connection.
     */
    'database' => env('DIRECTUS_DB_CONNECTION', 'sqlite'),

    /**
     * Will be used as the logo UUID.
     * Leave empty / null to have
     * it being auto-generated.
     */
    'logo_id' => env('DIRECTUS_LOGO_ID', null),

    'logo_path' => env('DIRECTUS_LOGO_PATH', 'public/images/logo.svg'),
    'logo_name' => 'logo.svg',
    'logo_type' => 'image/svg+xml',
    'logo_title' => 'Logo',
    'logo_storage' => 'local',

    /**
     * Path to the files describing the collection
     * Will be passed to glob()
     **/
    'collections_path_pattern' => env('DIRECTUS_COLLECTIONS_FILES_PATTERN', 'database/directus/collections/*.php'),

    /**
     * Path to the file containing the presets
     **/
    'presets_path' => env('DIRECTUS_PRESETS', 'database/directus/presets.php'),

    'models' => [
        'activity' => \SevenUte\Directavel\Models\DirectusActivity::class,
        'collections' => \SevenUte\Directavel\Models\DirectusCollections::class,
        'fields' => \SevenUte\Directavel\Models\DirectusFields::class,
        'presets' => \SevenUte\Directavel\Models\DirectusPresets::class,
        'relations' => \SevenUte\Directavel\Models\DirectusRelations::class,
        'revisions' => \SevenUte\Directavel\Models\DirectusRevisions::class,
    ],

    /**
     * /!\ ATTENTION
     * Each table that is set to true in the array below will be truncated.
     * The data tables wont be touched. It's recommanded to enable that
     * to maintain a portable setup but beware of unwanted deletions!
     */
    'wipe' => [
        'activity' => false,
        'collections' => false,
        'fields' => false,
        'presets' => false,
        'relations' => false,
        'revisions' => false,
    ],

    'tailwind_config_file' => env('DIRECTUS_TAILWIND_CONFIG_FILE', 'tailwind.config.js'),
    'tailwind_palette_file' => env('DIRECTUS_TAILWIND_PALETTE_FILE', null),
    'tailwind_directus_color_name' => 'accent',
    'tailwind_palette' => [
        '50' => '#fef6ee',
        '100' => '#fcebd8',
        '200' => '#f7d3b1',
        '300' => '#f2b37f',
        '400' => '#ec894b',
        '500' => '#e76a28',
        '600' => '#de541e',
        '700' => '#b43e1a',
        '800' => '#8f321d',
        '900' => '#742c1a',
        '950' => '#3e140c',
    ]
];
