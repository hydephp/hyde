<?php

namespace Tests\Feature\Commands;

use Hyde\Framework\Actions\CreatesDefaultDirectories;
use Hyde\Framework\Hyde;
use Tests\TestCase;

class BuildStaticSiteCommandTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        backupDirectory(Hyde::path('_site'));
        deleteDirectory(Hyde::path('_site'));

        (new CreatesDefaultDirectories)->__invoke();
    }

    protected function tearDown(): void
    {
        restoreDirectory(Hyde::path('_site'));

        parent::tearDown();
    }

    public function test_build_command_contains_expected_output()
    {
        $this->artisan('build')
            ->expectsOutputToContain('Building your static site')
            ->expectsOutputToContain('All done! Finished in')
            ->expectsOutput('Congratulations! 🎉 Your static site has been built!')
            ->assertExitCode(0);
    }

    public function test_build_command_creates_html_files()
    {
        $post = createTestPost();

        $this->artisan('build')
            ->assertExitCode(0);

        $this->assertFileExists(Hyde::path('_site/index.html'));
        $this->assertFileExists(Hyde::path('_site/posts/test-post.html'));

        unlinkIfExists($post);
    }

    public function test_build_command_transfers_media_asset_files()
    {
        file_put_contents(Hyde::path('_media/test-image.png'), 'foo');
        $this->artisan('build');
        $this->assertFileEquals(Hyde::path('_media/test-image.png'), Hyde::path('_site/media/test-image.png'));
        unlink(Hyde::path('_media/test-image.png'));
        unlink(Hyde::path('_site/media/test-image.png'));
    }

    public function test_print_initial_information_allows_api_to_be_disabled()
    {
        $this->artisan('build --no-api')
            ->expectsOutput('Disabling external API calls')
            ->assertExitCode(0);
    }

    public function test_handle_clean_option()
    {
        $this->artisan('build --clean')
            ->expectsOutput('The --clean option will remove all files in the output directory before building.')
            ->expectsConfirmation('Are you sure?')
            ->assertExitCode(1);

        $this->artisan('build --clean')
            ->expectsOutput('The --clean option will remove all files in the output directory before building.')
            ->expectsConfirmation('Are you sure?', 'yes')
            ->assertExitCode(0);
    }

    public function test_handle_purge_method()
    {
        touch(Hyde::path('_site/foo.html'));
        $this->artisan('build --clean --force')
            ->expectsOutput('Removing all files from build directory.')
            ->expectsOutput(' > Directory purged')
            ->expectsOutput(' > Recreating directories')
            ->assertExitCode(0);
        $this->assertFileDoesNotExist(Hyde::path('_site/foo.html'));
    }

    public function test_node_action_outputs()
    {
        $this->artisan('build --pretty --run-dev --run-prod')
            ->expectsOutput('Prettifying code! This may take a second.')
            ->expectsOutput('Building frontend assets for development! This may take a second.')
            ->expectsOutput('Building frontend assets for production! This may take a second.')
            ->assertExitCode(0);
    }
}
