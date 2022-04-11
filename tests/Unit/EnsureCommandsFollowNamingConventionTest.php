<?php

namespace Tests\Unit;

use Hyde\Framework\Hyde;
use Tests\TestCase;

class EnsureCommandsFollowNamingConventionTest extends TestCase
{
    public function test_ensure_commands_follow_naming_convention()
    {
        foreach (glob(Hyde::path('vendor/hyde/framework/src/commands/*.php')) as $filepath) {
            $filename = basename($filepath, '.php');
            $this->assertStringStartsWith('Hyde', $filename);
            $this->assertStringEndsWith('Command', $filename);
        }
    }
}
