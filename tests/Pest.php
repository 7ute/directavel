<?php

use SevenUte\Directavel\Tests\TestUtils;
use SevenUte\Directavel\Tests\TestCase;

uses(TestCase::class)
    ->beforeAll(function () {
        TestUtils::installDirectusForTests();
    })
    ->afterAll(function () {
        TestUtils::cleanupDirectusTestDirectories();
    })
    ->in(__DIR__);
