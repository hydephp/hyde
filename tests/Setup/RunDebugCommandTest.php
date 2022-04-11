<?php

namespace Tests\Setup;

use Tests\TestCase;

class RunDebugCommandTest extends TestCase
{
    /**
     * This "test" prints the debug output and is run before all other tests.
     */
    public function test_print_debug_info()
    {
        fwrite(STDOUT, (shell_exec('php hyde debug')));
        $this->assertTrue(true);
    }
}
