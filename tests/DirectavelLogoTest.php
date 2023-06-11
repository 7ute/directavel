<?php

use SevenUte\Directavel\Directavel;
use SevenUte\Directavel\Exceptions\DirectavelStorageMissingException;
use SevenUte\Directavel\Facades\Directavel as DirectavelFacade;

it('should preload the palette', function () {
    $instance = new Directavel();
    expect($instance->tailwind_palette)->toBeNull();
    $instance->updateProjectLogo();
    expect($instance->tailwind_palette->name)->toEqual('default');
});

it('should fail with an invalid logo path', function () {
    $logo_path = config('directavel.logo_path');
    config()->set('directavel.logo_path', $logo_path);
    config()->set('directavel.filesystem', 'non-existant-disk');

    expect(function () {
        new Directavel();
    })->toThrow(DirectavelStorageMissingException::class);
});

it('should fallback to a random UUID without logo ID', function () {
    $logo_path = config('directavel.logo_path');
    $logo = '<svg version="1.1" width="1024" height="1024" xmlns="http://www.w3.org/2000/svg"></svg>';

    File::put(base_path($logo_path), $logo);
    $instance = new Directavel();

    expect($instance->logo_id)->not->toBeIn(['11111111-2222-3333-4444-555555555555']);
});

it('should be set to logo ID if in config', function () {
    $logo_path = config('directavel.logo_path');
    config()->set('directavel.logo_id', '11111111-2222-3333-4444-555555555555');
    $logo = '<svg version="1.1" width="1024" height="1024" xmlns="http://www.w3.org/2000/svg"></svg>';

    File::put(base_path($logo_path), $logo);
    $instance = new Directavel();

    expect($instance->logo_id)->toEqual('11111111-2222-3333-4444-555555555555');
});

it('should work without a logo file', function () {
    $files = DB::table('directus_files')->count();
    expect($files)->toEqual(0);

    File::delete(base_path(config('directavel.logo_path')));

    $instance = new Directavel();
    expect($instance->logo_id)->toBeNull();

    $instance->updateProjectLogo();

    $files = DB::table('directus_files')->count();
    expect($files)->toEqual(0);
});
