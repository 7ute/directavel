<?php

namespace SevenUte\Directavel;

use SevenUte\Directavel\Directavel;
use Illuminate\Foundation\Application as LaravelApplication;
use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use SevenUte\Directavel\Commands\DirectavelClearCacheCommand;

class DirectavelServiceProvider extends BaseServiceProvider
{
    protected $commands = [
        DirectavelClearCacheCommand::class,
    ];

    public function boot(): void
    {
        $this->setUpConfig();
    }
    
    public function register()
    {
        $this->commands($this->commands);
        
        $this->app->singleton('directavel', function ($app) {
            return new Directavel();
        });
        $this->app->alias('directavel', Directavel::class);
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
