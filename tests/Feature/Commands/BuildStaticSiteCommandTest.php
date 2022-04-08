<?php

namespace Tests\Feature\Commands;

use Hyde\Framework\Hyde;
use Tests\Setup\ResetsDefaultDirectories;
use Tests\Setup\ResetsFileEnvironment;
use Tests\TestCase;

class BuildStaticSiteCommandTest extends TestCase
{
    use ResetsFileEnvironment;
    use ResetsDefaultDirectories;

    public function test_file_environment_is_prepared()
    {
        $this->resetFileEnvironment();

        $this->assertFileExists(Hyde::path('config/authors.yml'));
        $this->assertFileExists(Hyde::path('_posts/my-new-post.md'));
        $this->assertFileExists(Hyde::path('_posts/alice-in-wonderland.md'));
        $this->assertFileExists(Hyde::path('_pages/markdown.md'));

        $this->assertFileDoesNotExist(Hyde::path('_site/index.html'));
        $this->assertFileDoesNotExist(Hyde::path('_site/404.html'));

        $this->assertEquals(5, $this->countItemsInDirectory('_media'));

        $directoriesExpectedToBeEmpty = [
            '_docs',
        ];

        foreach ($directoriesExpectedToBeEmpty as $directory) {
            $this->assertTrue($this->checkIfDirectoryIsEmpty($directory), "Directory $directory is not empty.");
        }
    }

    public function test_command_returns_zero_exit_code()
    {
        $this->artisan('build')->assertExitCode(0);
    }

    public function test_build_command_contains_expected_output()
    {
        $this->artisan('build')
            ->expectsOutputToContain('Building your static site')
            ->expectsOutput('Transferring Media Assets...')
            ->expectsOutput('Creating Markdown Posts...')
            ->expectsOutput('No Documentation Pages found. Skipping...')
            ->expectsOutput('Creating Blade Pages...')
            ->expectsOutputToContain('All done! Finished in')
            ->expectsOutput('Congratulations! 🎉 Your static site has been built!')
            ->expectsOutput('Your new homepage is stored here -> file://' . str_replace(
                '\\',
                '/',
                realpath(Hyde::path('_site'))
            ) . '/index.html')
            ->assertExitCode(0);
    }

    public function test_build_command_creates_html_files()
    {
        $this->assertFileExists(Hyde::path('_site/index.html'));
        $this->assertFileExists(Hyde::path('_site/404.html'));
        $this->assertFileExists(Hyde::path('_site/posts/my-new-post.html'));
    }

    public function test_build_command_transfers_media_asset_files()
    {
        $this->assertEquals(7, $this->countItemsInDirectory('_site/media'));
    }

    public function test_compiled_index_file_seems_valid()
    {
        $file = Hyde::path('_site/index.html');
        $this->assertFileExists($file);
        $this->assertGreaterThan(1024, filesize($file), 'Failed asserting that index.html is larger than one kilobyte');
        $stream = file_get_contents($file);
        $this->assertStringContainsStringIgnoringCase('<!DOCTYPE html>', $stream);
        $this->assertStringContainsString('HydePHP', $stream);
        unset($stream);
    }

    public function test_compiled_404_file_seems_valid()
    {
        $file = Hyde::path('_site/404.html');
        $this->assertFileExists($file);
        $this->assertGreaterThan(1024, filesize($file), 'Failed asserting that 404.html is larger than one kilobyte');
        $stream = file_get_contents($file);
        $this->assertStringContainsStringIgnoringCase('<!DOCTYPE html>', $stream);
        $this->assertStringContainsString('<title>404 - Page not found</title>', $stream);
        $this->assertStringContainsString('Sorry, the page you are looking for could not be found.', $stream);
        unset($stream);
    }

    // Full post validations will be in a separate feature test
    public function test_blog_posts_were_created()
    {
        $this->assertFileExists(Hyde::path('_site/posts/my-new-post.html'));
        $this->assertFileExists(Hyde::path('_site/posts/alice-in-wonderland.html'));
    }

    public function test_progress_bars_are_skipped_when_source_files_are_empty()
    {
        $this->resetDefaultDirectories();
        $this->artisan('build')
            ->expectsOutput('No Markdown Posts found. Skipping...')
            ->expectsOutput('No Markdown Pages found. Skipping...')
            ->expectsOutput('No Documentation Pages found. Skipping...')
            ->expectsOutput('No Blade Pages found. Skipping...')
            ->assertExitCode(0);
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

    private function checkIfDirectoryIsEmpty(string $directory): bool
    {
        $scan = scandir(Hyde::path($directory), SCANDIR_SORT_NONE);
        if ($scan) {
            return !isset($scan[2]);
        }

        return false;
    }

    private function countItemsInDirectory(string $directory): int
    {
        $scan = scandir(Hyde::path($directory), SCANDIR_SORT_NONE);

        return count($scan) - 2;
    }
}
