<?php

namespace SevenUte\Directavel\Commands;

use Illuminate\Console\Command;
use SevenUte\Directavel\Facades\Directavel;

/**
 * @codeCoverageIgnore
 */
class DirectavelClearCacheCommand extends Command
{
    protected $signature = 'directavel:cache:clear';
    protected $description = 'Clears Directus collection cache';

    public function handle()
    {
        Directavel::clearCache();
    }
}
