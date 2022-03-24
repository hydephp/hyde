<?php

namespace Hyde\Framework\Commands;

use Tests\TestCase;
use Hyde\Framework\Hyde;

class HydePublishHomepageCommandTest extends TestCase
{
    /**
     * The filepath of the post
     *
     * @var string
     */
    protected string $file;

    public function __construct()
    {
        parent::__construct();

        $this->file = Hyde::path('resources/views/pages/index.blade.php');
    }
    
    /**
     * Setup the test environment.
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        if (file_exists($this->file)) {
            unlink($this->file);
        }
    }

    public function test_command_returns_expected_output()
    {
        $this->artisan('publish:homepage')
            ->expectsQuestion('Which homepage do you want to publish?', 'homepage-welcome')
            ->expectsOutput('Selected page [welcome]')
            ->expectsOutput('Published selected homepage')
            ->expectsQuestion('Would you like to rebuild the site?', 'no')
            ->assertExitCode(0);
    }
    
    public function test_file_gets_published()
    {
        $this->assertFileDoesNotExist($this->file);

        $this->artisan('publish:homepage')
            ->expectsQuestion('Which homepage do you want to publish?', 'homepage-welcome')
            ->expectsOutput('Published selected homepage')
            ->expectsQuestion('Would you like to rebuild the site?', 'no')
            ->assertExitCode(0);
        
        $this->assertFileExists($this->file);
    }

    public function test_that_files_are_not_overwritten_by_default()
    {
        file_put_contents($this->file, 'This should not be overwritten');

        $this->artisan('publish:homepage')
            ->expectsQuestion('Which homepage do you want to publish?', 'homepage-welcome')
            ->expectsOutput('Published selected homepage')
            ->expectsQuestion('Would you like to rebuild the site?', 'no')
            ->assertExitCode(0);

        $this->assertFileExists($this->file);
        
        $this->assertStringContainsString(
            'This should not be overwritten',
            file_get_contents($this->file)
        );
    }
    
    public function test_that_files_are_overwritten_when_force_flag_is_set()
    {
        file_put_contents($this->file, 'This should be overwritten');

        $this->artisan('publish:homepage --force')
            ->expectsQuestion('Which homepage do you want to publish?', 'homepage-welcome')
            ->expectsOutput('Published selected homepage')
            ->expectsQuestion('Would you like to rebuild the site?', 'no')
            ->assertExitCode(0);

        $this->assertFileExists($this->file);
        
        $this->assertStringNotContainsString(
            'This should be overwritten',
            file_get_contents($this->file)
        );
    }

    public function test_can_select_and_publish_blank()
    {
        $this->artisan('publish:homepage')
            ->expectsQuestion('Which homepage do you want to publish?', 'homepage-blank')
            ->expectsOutput('Selected page [blank]')
            ->expectsQuestion('Would you like to rebuild the site?', 'no')
            ->assertExitCode(0);

            $stream = file_get_contents($this->file);
            $this->assertStringContainsString(
                '<h1 class="text-center text-3xl font-bold">Hello World!</h1>',
                $stream
            );
            $this->assertStringNotContainsString('Latest Posts', $stream);
            $this->assertStringNotContainsString('This is the default homepage stored as index.blade.php', $stream);
    }
    
    public function test_can_select_and_publish_post_feed()
    {
        $this->artisan('publish:homepage')
            ->expectsQuestion('Which homepage do you want to publish?', 'homepage-post-feed')
            ->expectsOutput('Selected page [post-feed]')
            ->expectsQuestion('Would you like to rebuild the site?', 'no')
            ->assertExitCode(0);
                
            $stream = file_get_contents($this->file);
            $this->assertStringNotContainsString(
                '<h1 class="text-center text-3xl font-bold">Hello World!</h1>',
                $stream
            );
            $this->assertStringContainsString('Latest Posts', $stream);
            $this->assertStringNotContainsString('This is the default homepage stored as index.blade.php', $stream);
    }

    public function test_can_select_and_publish_welcome()
    {
        $this->artisan('publish:homepage')
            ->expectsQuestion('Which homepage do you want to publish?', 'homepage-welcome')
            ->expectsOutput('Selected page [welcome]')
            ->expectsQuestion('Would you like to rebuild the site?', 'no')
            ->assertExitCode(0);
                
            $stream = file_get_contents($this->file);
            $this->assertStringNotContainsString(
                '<h1 class="text-center text-3xl font-bold">Hello World!</h1>',
                $stream
            );
            $this->assertStringNotContainsString('Latest Posts', $stream);
            $this->assertStringContainsString('This is the default homepage stored as index.blade.php', $stream);
    }

    public function test_ask_to_rebuild_site_prompt_handles_decline()
    {
        $this->artisan('publish:homepage')
            ->expectsQuestion('Which homepage do you want to publish?', 'homepage-welcome')
            ->expectsQuestion('Would you like to rebuild the site?', 'no')
            ->expectsOutput('Okay, you can always run the build later!')
            ->assertExitCode(0);
    }

    public function test_ask_to_rebuild_site_prompt_handles_affirmative_response()
    {
        $this->artisan('publish:homepage')
            ->expectsQuestion('Which homepage do you want to publish?', 'homepage-welcome')
            ->expectsQuestion('Would you like to rebuild the site?', 'yes')
            ->expectsOutput('Okay, building site!')
            ->expectsOutput('Site is built!')
            ->assertExitCode(0);
    }
    
    public function test_site_was_not_rebuilt_after_declined_response()
    {
        // Remove any old files first
        if (file_exists(Hyde::path('_site/index.html'))) {
            unlink(Hyde::path('_site/index.html'));
        }
        $this->assertFileDoesNotExist(Hyde::path('_site/index.html'));

        $this->artisan('publish:homepage')
            ->expectsQuestion('Which homepage do you want to publish?', 'homepage-welcome')
            ->expectsQuestion('Would you like to rebuild the site?', 'n')
            ->expectsOutput('Okay, you can always run the build later!')
            ->assertExitCode(0);

        $this->assertFileDoesNotExist(Hyde::path('_site/index.html'));
    }

    public function test_site_was_rebuilt_after_affirmative_response()
    {
        // Remove any old files first
        if (file_exists(Hyde::path('_site/index.html'))) {
            unlink(Hyde::path('_site/index.html'));
        }
        $this->assertFileDoesNotExist(Hyde::path('_site/index.html'));

        $this->artisan('publish:homepage')
            ->expectsQuestion('Which homepage do you want to publish?', 'homepage-welcome')
            ->expectsQuestion('Would you like to rebuild the site?', 'y')
            ->expectsOutput('Okay, building site!')
            ->expectsOutput('Site is built!')
            ->assertExitCode(0);

        $this->assertFileExists(Hyde::path('_site/index.html'));
    }
}
