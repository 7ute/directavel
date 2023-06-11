<?php

namespace SevenUte\Directavel\Tests;

use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\File;

class TestUtils
{
    /**
     * Installs a fresh copy of directus and copies it to `tests/directus-initial`
     */
    public static function installDirectusForTests(): void
    {
        static::cleanupDirectusTestDirectories();
        shell_exec('CONFIG_PATH=".env.testing" npx directus bootstrap');
        shell_exec('cp -R tests/directus/ tests/directus-initial/');
    }

    /**
     * Copies the untouched Directus from `tests/directus-initial` to `tests/directus`
     */
    public static function copyDirectusFromInitial(): void
    {
        shell_exec('rm -rf tests/directus');
        shell_exec('cp -R tests/directus-initial/ tests/directus/');
    }

    /**
     * Cleans both `tests/directus-initial` and `tests/directus`
     */
    public static function cleanupDirectusTestDirectories(): void
    {
        shell_exec('rm -rf tests/directus-initial');
        shell_exec('rm -rf tests/directus');
    }

    /**
     * Sets up the database and local filesystem to share it with Directus
     */
    public static function setupAppConfig(Application $app): void
    {
        $app->config->set('database.default', 'sqlite');
        $app->config->set('database.connections.sqlite', [
            'driver'   => 'sqlite',
            'database' => 'tests/directus/database.sqlite',
            'prefix'   => '',
        ]);
        $app->config->set('filesystems.disks.directus', [
            'driver' => 'local',
            'root' => realpath(__DIR__ . '/filesystem'),
            'throw' => false,
        ]);
    }

    public static function copyDummies()
    {
        static::copyToTestbench('dummies/tailwind.palettes.js', 'tailwind.palettes.js');
        static::copyToTestbench('dummies/tailwind.config.js', 'tailwind.config.js');
        static::copyToTestbench('dummies/logo.svg', 'public/logo.svg');
        static::copyToTestbench('dummies/presets.php', 'database/directus/presets.php');
        static::copyToTestbench('dummies/collections/no-attributes.php', 'database/directus/collections/no-attributes.php');
        static::copyToTestbench('dummies/collections/with-attributes.php', 'database/directus/collections/with-attributes.php');
    }

    public static function cleanDummies()
    {
        File::delete(base_path('tailwind.palettes.js'));
        File::delete(base_path('tailwind.config.js'));
        File::delete(base_path('public/logo.svg'));
        File::delete(base_path('database/directus/presets.php'));
        File::delete(base_path('database/directus/collections/no-attributes.php'));
        File::delete(base_path('database/directus/collections/with-attributes.php'));
    }

    public static function getRootTestPath($file = null)
    {
        return realpath(__DIR__) . ($file ? '/' . $file : '');
    }

    public static function copyToTestbench($file, $destination_file)
    {
        if (strpos($destination_file, '../') !== false) {
            throw new Exception('No navigation in the path, or you’ll erase unwanted things and drama will ensue.');
        }
        if (substr($destination_file, 0, 1) == '/') {
            throw new Exception('No absolute, or you’ll erase unwanted things and drama will ensue.');
        }
        $destination_path = base_path($destination_file);
        $source_path = static::getRootTestPath($file);
        if (File::isDirectory($source_path)) {
            throw new Exception('Let’s stick to copying only files, not directories, shall we ?');
        }
        File::delete($destination_path);
        File::makeDirectory(dirname($destination_path), 0700, true, true);
        File::copy($source_path, $destination_path);
    }
}
