<?php

namespace Hyde\Testing\Hyde\Feature;

use Hyde\Framework\Hyde;
use Hyde\Testing\TestCase;
use Illuminate\Support\Facades\File;

class StaticSiteBuilderTest extends TestCase
{
    public function test_can_build_static_site()
    {
        File::deleteDirectory(Hyde::path('_site'));
        File::makeDirectory(Hyde::path('_site'));

        $this->artisan('build')
            ->expectsOutputToContain('Building your static site!')
            ->assertExitCode(0);
    }
}
