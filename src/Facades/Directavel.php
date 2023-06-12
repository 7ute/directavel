<?php

namespace SevenUte\Directavel\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static Directavel loadCurrentAdminId()
 * @method static Directavel updateProjectAdmin()
 * @method static Directavel updateProjectLogo()
 * @method static Directavel updateProjectPresets()
 * @method static Directavel updateThemeCss()
 * @method static Directavel loadTailwindThemeColors()
 * @method static Directavel synchronizeDatabase()
 * @method static array getStructure()
 * @method static void clearCache()
 *
 * @see \SevenUte\Directavel\DirectavelManager
 */
class Directavel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'directavel';
    }
}
