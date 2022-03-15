<?php

namespace Tests;

use LaravelZero\Framework\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    /**
     * Setup the test environment.
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
    }

    /**
     * Clean up the testing environment before the next test.
     * @return void
     */
    protected function tearDown(): void
    {
        parent::tearDown();
    }
}
