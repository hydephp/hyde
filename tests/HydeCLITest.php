<?php

declare(strict_types=1);

namespace Hyde\Testing;

class HydeCLITest extends TestCase
{
    public function testCanShowHydeConsole()
    {
        $this->artisan('list')
            ->expectsOutputToContain('Hyde')
            ->assertExitCode(0);
    }
}
