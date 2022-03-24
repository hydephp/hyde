<?php

namespace Tests\Feature\Commands;

use Tests\TestCase;
use Hyde\Framework\Hyde;
use Tests\Setup\ResetsDefaultDirectories;
use Tests\Setup\ResetsFileEnvironment;

class BuildStaticSiteCommandTest extends TestCase
{
    use ResetsFileEnvironment;
    use ResetsDefaultDirectories;

    public function test_file_environment_is_prepared()
    {
        $this->resetFileEnvironment();

        $this->assertFileExists(Hyde::path('_data/authors.yml'));
        $this->assertFileExists(Hyde::path('_posts/my-new-post.md'));
        $this->assertFileExists(Hyde::path('_posts/alice-in-wonderland.md'));
        $this->assertFileExists(Hyde::path('_pages/markdown.md'));

        $this->assertFileDoesNotExist(Hyde::path('_site/index.html'));
        $this->assertFileDoesNotExist(Hyde::path('_site/404.html'));

        $this->assertEquals(5, $this->countItemsInDirectory('_media'));

        $directoriesExpectedToBeEmpty = [
            '_docs',
            '_drafts',
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
            ->expectsOutput('Creating Custom Blade Pages...')
            ->expectsOutputToContain('All done! Finished in')
            ->expectsOutput('Congratulations! 🎉 Your static site has been built!')
            ->expectsOutput("Your new homepage is stored here -> file://" . str_replace(
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
        $this->assertEquals(5, $this->countItemsInDirectory('_site/media'));
    }

    public function test_compiled_index_file_seems_valid()
    {
        $file = Hyde::path('_site/index.html');
        $this->assertFileExists($file);
        $this->assertGreaterThan(1024, filesize($file), 'Failed asserting that index.html is larger than one kilobyte');
        $stream = file_get_contents($file);
        $this->assertStringContainsStringIgnoringCase('<!DOCTYPE html>', $stream);
        $this->assertStringContainsString('HydePHP', $stream);
        $this->assertStringContainsString('tailwind', $stream);
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
            ->expectsOutput('No Media Assets found. Skipping...')
            ->expectsOutput('No Markdown Posts found. Skipping...')
            ->expectsOutput('No Markdown Pages found. Skipping...')
            ->expectsOutput('No Documentation Pages found. Skipping...')
            ->expectsOutput('No Blade Pages found. Skipping...')
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
