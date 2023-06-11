<?php

namespace SevenUte\Directavel\Tests;

use Exception;
use Illuminate\Foundation\Bootstrap\LoadEnvironmentVariables;
use Illuminate\Support\Facades\Http;
use Orchestra\Testbench\TestCase as Orchestra;
use SevenUte\Directavel\DirectavelServiceProvider;

class TestCase extends Orchestra
{
    protected function getPackageProviders($app)
    {
        return [
            DirectavelServiceProvider::class,
        ];
    }

    protected function setUp(): void
    {
        TestUtils::copyDirectusFromInitial();
        parent::setUp();
        Http::preventStrayRequests();
        $this->beforeApplicationDestroyed(function () {
            TestUtils::cleanDummies();
        });
    }

    protected function getEnvironmentSetUp($app): void
    {
        $app->bootstrapWith([LoadEnvironmentVariables::class]);
        parent::getEnvironmentSetUp($app);
        TestUtils::setupAppConfig($app);
        TestUtils::copyDummies();
    }
}
