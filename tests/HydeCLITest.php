<?php

declare(strict_types=1);

namespace Hyde\Testing\Hyde;

use Hyde\Testing\TestCase;

class HydeCLITest extends TestCase
{
    public function testCanShowHydeConsole()
    {
        $this->artisan('list')
            ->expectsOutputToContain('hyde')
            ->assertExitCode(0);
    }
}
