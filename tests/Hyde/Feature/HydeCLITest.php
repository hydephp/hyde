<?php

namespace Hyde\Testing\Hyde\Feature;

use Hyde\Testing\TestCase;

class HydeCLITest extends TestCase
{
    public function test_can_show_hyde_console()
    {
        $this->artisan('list')
            ->expectsOutputToContain('Hyde')
            ->assertExitCode(0);
    }
}
