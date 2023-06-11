# Directavel

Directavel helps using [Directus](https://directus.io/) as an administrative backend for [Laravel](http://laravel.com).
It provides some commands to programmatically define and version Directus collections.

<p align="center">
<img href="https://github.com/7ute/Directavel/workflows/tests/badge.svg"><img src="https://github.com/7ute/Directavel/workflows/tests/badge.svg" alt="Tests"></img></a>
<a href="LICENSE"><img src="https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square" alt="Software License"></img></a>
<a href="https://github.com/7ute/Directavel/releases"><img src="https://img.shields.io/github/release/7ute/Directavel.svg?style=flat-square" alt="Latest Version"></img></a>
</p>


## Installation

Directavel requires [PHP](https://php.net) 8.0+, [Laravel](https://laravel.com/) 10.x+ and [Directus](https://directus.io/) 9.x+.
To get the latest version, simply require the project using [Composer](https://getcomposer.org):

```bash
composer require SevenUte/Directavel
```

Directus must be installed and bootstraped, and the migrations must have been run already.
You can bootstrap it by running the following **in the directus project directory** :
```bash
npx directus bootstrap
npx directus database migrate:latest
```

## Configuration

To customize the directus configuration, you first must publish the config.

```bash
$ php artisan vendor:publish
```

This will create a `config/directavel.php` file in your app that you can modify to set your configuration.
Make sure you check for changes to the original config file in this package between releases.

## Collections

Each collection is defined by a PHP file named after the table we want to configure.
The collections sits at the path set in the `directavel.collections_path_pattern` config entry.

A configuration files is composed as following :

```php

// database/directus/collections/some_table.php

/**
 * That file will help generating a `some_table`
 * entry in the `directus_collections` table
 * with only the collection column filled.
 **/
return [
    /** The other columns of this `directus_collection` entry. */
    'attributes' => [],

    /** Each field will be its own row in the `directus_fields` table */
    'fields' => [],

    /**
     * The relationships that are not set in the fields
     * can be defined here. They will be inserted at
     * the end of the `directus_relations` table.
     **/
    'relations' => [],
]
```

To see an example, check the [sample.php](https://github.com/7ute/Directavel/blob/master/database/directus/collections/sample.php) file in this package.
You can also refer to the [DirectusFields](https://github.com/7ute/Directavel/blob/master/src/Models/DirectusFields.php) model for a list of available fields and some typing for your IDE, and the [DirectusCollections](https://github.com/7ute/Directavel/blob/master/src/Models/DirectusCollections.php) and [DirectusRelations](https://github.com/7ute/Directavel/blob/master/src/Models/DirectusRelations.php) for the available columns.

## Presets
The general presets can be defined in a file at the path set in the `directavel.presets_path` config entry.
Some default config for the `directus_activity`, `directus_presets` and `directus_users` views are included in the [presets.php](https://github.com/7ute/Directavel/blob/master/database/directus/presets.php) file of this project.

## Usage
Once the collections are configured, you can use the `Directavel` facade in a migration, or use the command to trigger a full refresh of Directus collections / fields without touching your non-directus data tables.

> **Warning**
> All your existing Activityn Collections, Fields, Presets, Relations and Revisions might be wiped, depending on your settings in the config file.

### Commands

- `php artisan directavel:sync`: Update the admin user, settings and presets, and synchronises the collections and fields
- `php artisan directavel:cache:clear`: Clears Directus inner cache

### Facade

```php
use SevenUte\Directavel\Directavel;

Directavel::updateProjectAdmin()
    ->updateProjectPresets()
    ->updateThemeCss()
    ->synchronizeDatabase()
    ->clearCache();
```
- `updateProjectAdmin`: Updates the Directus admin user ;
- `updateProjectLog`: Updates the Directus logo ;
- `updateProjectPresets`: Reload the non-user presets from the file defined in the `directus.presets_path` config ;
- `updateThemeCss`: Applies the theme color and extra CSS ;
- `synchronizeDatabase`: Loads the collections, fields and relations into the directus tables, wiping those set in the `directus.wipe` config before ;
- `clearCache`: Clears Directus collection cache to prevent "inexistant field" errors ;
- `loadTailwindThemeColors`: Reloads the Tailwind theme colors ;
- `loadCurrentAdminId`: Reloads the Directus admin user ID.

## Security
If you discover a security vulnerability within this package, please send an e-mail to Julien Cauvin at contact@7ute.fr.
All security vulnerabilities will be promptly addressed.

## License
Directavel is licensed under [The MIT License (MIT)](LICENSE).
