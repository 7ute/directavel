<?php

namespace SevenUte\Directavel\Commands;

use Illuminate\Console\Command;
use SevenUte\Directavel\Facades\Directavel;

/**
 * @codeCoverageIgnore
 */
class DirectavelSync extends Command
{
    protected $signature = 'directavel:sync';
    protected $description = 'Apply latest collections and settings changes to directus';

    public function handle()
    {
        Directavel::updateProjectAdmin()
            ->updateProjectPresets()
            ->updateThemeCss()
            ->synchronizeDatabase()
            ->clearCache();
    }
}
