<?php

use SevenUte\Directavel\DirectavelManager;
use SevenUte\Directavel\Facades\Directavel as DirectavelFacade;

test('config tailwind palette works', function () {
    $instance = new DirectavelManager();

    config()->set('directavel.tailwind_palette_file', null);
    
    $instance->loadTailwindThemeColors();
    expect($instance->tailwind_palette)->toHaveProperty('name', 'default');

    config()->set('directavel.tailwind_palette_file', 'non-existant-tailwind.palettes.js');

    $instance->loadTailwindThemeColors();
    expect($instance->tailwind_palette)->toHaveProperty('name', 'default');
});

test('config tailwind from file works', function () {
    $instance = new DirectavelManager();
    
    config()->set('directavel.tailwind_palette_file', 'tailwind.palettes.js');
    config()->set('directavel.tailwind_config_file', 'tailwind.config.js');

    $instance->loadTailwindThemeColors();
    expect($instance->tailwind_palette)->toHaveProperty('name', 'matisse');
});
