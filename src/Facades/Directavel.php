<?php

namespace SevenUte\Directavel\Facades;

use Illuminate\Support\Facades\Facade;

class Directavel extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'directavel';
    }
}
