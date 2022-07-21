<?php

namespace Hyde\Testing;

use Illuminate\Support\Facades\Facade;
use Laravel\Dusk\Browser;
use Laravel\Dusk\TestCase as BaseTestCase;
use LaravelZero\Framework\Providers\CommandRecorder\CommandRecorderRepository;
use NunoMaduro\Collision\ArgumentFormatter;

abstract class DuskBaseTestCase extends BaseTestCase
{
    /**
     * Setup the test environment.
     */
    protected function setUp(): void
    {
        // \LaravelZero\Framework\Testing\TestCase instead \Illuminate\Foundation\Testing\TestCase
        if (! $this->app) {
            $this->refreshApplication();
        }

        $this->setUpTraits();

        foreach ($this->afterApplicationCreatedCallbacks as $callback) {
            call_user_func($callback);
        }

        Facade::clearResolvedInstances();

        if (class_exists(\Illuminate\Database\Eloquent\Model::class)) {
            \Illuminate\Database\Eloquent\Model::setEventDispatcher($this->app['events']);
        }

        $this->setUpHasRun = true;

        // \Laravel\Dusk\TestCase

        Browser::$baseUrl = 'http://localhost:8080';
        // Browser::$baseUrl = $this->baseUrl();

        Browser::$storeScreenshotsAt = base_path('tests/Browser/screenshots');

        Browser::$storeConsoleLogAt = base_path('tests/Browser/console');

        Browser::$storeSourceAt = base_path('tests/Browser/source');

        Browser::$userResolver = function () {
            return $this->user();
        };
    }

    /**
     * Assert that a command was called using the given arguments.
     *
     * @param  string  $command
     * @param  array  $arguments
     */
    protected function assertCommandCalled(string $command, array $arguments = []): void
    {
        $argumentsAsString = (new ArgumentFormatter)->format($arguments);
        $recorder = app(CommandRecorderRepository::class);

        static::assertTrue($recorder->exists($command, $arguments),
            'Failed asserting that \''.$command.'\' was called with the given arguments: '.$argumentsAsString);
    }

    /**
     * Assert that a command was not called using the given arguments.
     *
     * @param  string  $command
     * @param  array  $arguments
     */
    protected function assertCommandNotCalled(string $command, array $arguments = []): void
    {
        $argumentsAsString = (new ArgumentFormatter)->format($arguments);
        $recorder = app(CommandRecorderRepository::class);

        static::assertFalse($recorder->exists($command, $arguments),
            'Failed asserting that \''.$command.'\' was not called with the given arguments: '.$argumentsAsString);
    }
}
