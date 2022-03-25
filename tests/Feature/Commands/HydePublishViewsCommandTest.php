<?php

namespace Hyde\Framework\Commands;

use Tests\TestCase;

class HydePublishViewsCommandTest extends TestCase
{
    public function test_command_publishes_views()
    {
        $this->artisan('publish:views --all')
            ->expectsOutput('Publishing complete.')
            ->assertExitCode(0);
    }

    public function test_command_prompts_for_input()
    {
        $this->artisan('publish:views')
            ->expectsQuestion('Which view categories (tags) would you like to publish?', 'Tag: hyde-components')
            ->assertExitCode(0);
    }
 
}
