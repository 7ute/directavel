<?php

namespace SevenUte\Directavel;

use SevenUte\Directavel\DirectavelManager;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Foundation\Console\AboutCommand;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SevenUte\Directavel\Commands\DirectavelClearCacheCommand;
use SevenUte\Directavel\Commands\DirectavelSync;

class DirectavelServiceProvider extends BaseServiceProvider
{
    protected $commands = [
        DirectavelClearCacheCommand::class,
        DirectavelSync::class,
    ];

    public function boot(): void
    {
        $this->setUpConfig();
    }
    
    public function register()
    {
        $this->commands($this->commands);
        
        $this->app->singleton('directavel', function ($app) {
            return new DirectavelManager();
        });
        $this->app->alias('directavel', DirectavelManager::class);
    }

    public function provides(): array
    {
        return [
            'directavel',
        ];
    }

    protected function setUpConfig(): void
    {
        $source = dirname(__DIR__) . '/config/directavel.php';
        $this->publishes([$source => config_path('directavel.php')], 'config');
        $this->mergeConfigFrom($source, 'directavel');
    }
}
