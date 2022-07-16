<?php

namespace Hyde\Testing;

use Hyde\Framework\Hyde;
use Hyde\Framework\Models\Pages\MarkdownPage;
use Hyde\Framework\Models\Route;
use LaravelZero\Framework\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;
    use ResetsApplication;

    protected static bool $booted = false;

    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (! static::$booted) {
            $this->resetApplication();

            Hyde::macro('touch', function (string|array $path) {
                if (is_array($path)) {
                    foreach ($path as $p) {
                        touch(Hyde::path($p));
                    }
                } else {
                    return touch(Hyde::path($path));
                }
            });

            Hyde::macro('unlink', function (string|array $path) {
                if (is_array($path)) {
                    foreach ($path as $p) {
                        unlink(Hyde::path($p));
                    }
                } else {
                    return unlink(Hyde::path($path));
                }
            });

            static::$booted = true;
        }
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }

    /** @internal */
    protected function mockRoute(?Route $route = null)
    {
        view()->share('currentRoute', $route ?? (new Route(new MarkdownPage())));
    }

    /** @internal */
    protected function mockPage()
    {
        view()->share('page', new MarkdownPage());
        view()->share('currentPage', 'PHPUnit');
    }
}
