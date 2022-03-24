<?php

namespace Tests\Setup;

use PHPUnit\Framework\TestCase;

class EnsureAppEnvIsTestingSmokeTest extends TestCase
{
    public function test_app_env_is_testing()
    {
        $this->assertEquals('testing', app('env'));
    }
}
