<?php

namespace Tests\Setup;

use Tests\TestCase;

class EnsureAppEnvIsTestingSmokeTest extends TestCase
{
    public function test_app_env_is_testing()
    {
        $this->assertEquals('testing', app('env'));
    }
}
