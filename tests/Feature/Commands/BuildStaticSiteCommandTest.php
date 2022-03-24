<?php

namespace Tests\Feature\Commands;

use Hyde\Framework\Actions\CreatesDefaultDirectories;
use Tests\TestCase;
use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class BuildStaticSiteCommandTest extends TestCase
{
    private function resetFileEnvironment()
    {
        Artisan::call('stubs:publish --clean --force');
        $this->assertTrue(File::deleteDirectory(Hyde::path('_site')), 'Could not delete directory _site.');
        (new CreatesDefaultDirectories)->__invoke();
    }

    public function test_file_environment_is_prepared()
    {
        $this->resetFileEnvironment();

        $this->assertFileExists(Hyde::path('_data/authors.yml'));
        $this->assertFileExists(Hyde::path('_posts/my-new-post.md'));
        $this->assertFileExists(Hyde::path('_posts/alice-in-wonderland.md'));

        $this->assertFileDoesNotExist(Hyde::path('_site/index.html'));
        $this->assertFileDoesNotExist(Hyde::path('_site/404.html'));

        $directoriesExpectedToBeEmpty = [
            '_docs',
            '_drafts',
            '_media',
            '_pages',
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
            ->expectsOutput('No Media Assets found. Skipping...')
            ->expectsOutput('Creating Markdown Posts...')
            ->expectsOutput('No Markdown Pages found. Skipping...')
            ->expectsOutput('No Documentation Pages found. Skipping...')
            ->expectsOutput('Creating Custom Blade Pages...')
            ->expectsOutputToContain('All done! Finished in')
            ->expectsOutput('Congratulations! 🎉 Your static site has been built!')
            ->expectsOutput("Your new homepage is stored here -> file://" . str_replace(
                '\\',
                '/',
                realpath(Hyde::path('_site'))) . '/index.html')
            ->assertExitCode(0);
    }

    public function test_build_command_creates_files()
    {
        $this->assertFileExists(Hyde::path('_site/index.html'));
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

    private function checkIfDirectoryIsEmpty(string $directory): bool
    {
        $scan = scandir(Hyde::path($directory), SCANDIR_SORT_NONE); 
        if ($scan) {
            return !isset($scan[2]);
        }
        return false; 
    }
}
