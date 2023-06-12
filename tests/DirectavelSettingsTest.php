<?php

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use SevenUte\Directavel\DirectavelManager;
use SevenUte\Directavel\Exceptions\DirectavelStorageMissingException;
use SevenUte\Directavel\Facades\Directavel as DirectavelFacade;

it('should preload the palette', function () {
    $instance = new DirectavelManager();
    expect($instance->tailwind_palette)->toBeNull();
    $instance->updateThemeCss();
    expect($instance->tailwind_palette->name)->toEqual('default');
});

it('should update the project settings', function () {
    $settings = DB::table('directus_settings')->first();
    expect($settings)->toBeNull();

    DirectavelFacade::updateThemeCss();

    $settings = DB::table('directus_settings')->first();
    expect($settings->project_color)->not->toBeNull();
    expect($settings->custom_css)->not->toBeNull();
});

it('should update the presets', function () {
    $presets = DB::table('directus_presets')->first();
    expect($presets)->toBeNull();

    DirectavelFacade::updateProjectPresets();

    $nb_presets = DB::table('directus_presets')->count();
    expect($nb_presets)->toEqual(3);
});

it('should clear Directus internal cache', function () {
    Http::fake();
    expect(DirectavelFacade::clearCache())->toBeTrue();
});

it('should fail at clearing Directus internal cache', function () {
    Http::fake([
        '*' => Http::response('Fail', 400),
    ]);
    Log::shouldReceive('error')
        ->once()
        ->withArgs(function ($message) {
            return strpos($message, 'Emptying directus cache failed.') !== false;
        });
    DirectavelFacade::clearCache();
});
