<?php

use SevenUte\Directavel\DirectavelServiceProvider;
use SevenUte\Directavel\Facades\Directavel as DirectavelFacade;

test('service provider is correctly defined', function () {
    $facade = DirectavelFacade::class;
    $provider = DirectavelServiceProvider::class;

    $reflection = new ReflectionClass($provider);
    $method = $reflection->getMethod('provides');
    $method->setAccessible(true);

    $facade_reflection = new ReflectionClass($facade);
    $facade_method = $facade_reflection->getMethod('getFacadeAccessor');
    $facade_method->setAccessible(true);

    $binding = $facade_method->invoke(null);
    $bindings = $method->invoke(new $provider($this->app));

    expect($bindings)->toContain($binding);
});

test('confirm environment is set to testing', function () {
    expect(config('app.env'))->toBe('testing');
});

test('confirm Directavel configuration is defined', function () {
    expect(config('directavel.app_name'))->toBe('Directus');
});
