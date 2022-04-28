<?php

namespace Tests\Setup;

use Tests\TestCase;

/**
 * @deprecated as this was made to print debug messages in GitHub actions, which can be done (better) by simply running the command as a step in the runner.
 */
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
