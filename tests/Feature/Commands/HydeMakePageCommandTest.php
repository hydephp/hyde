<?php

namespace Tests\Feature\Commands;

use Exception;
use Hyde\Framework\Hyde;
use Tests\TestCase;

class HydeMakePageCommandTest extends TestCase
{
    protected string $markdownPath;
    protected string $bladePath;

    public function __construct()
    {
        parent::__construct();

        $this->markdownPath = Hyde::path('_pages/8450de2-test-page.md');
        $this->bladePath = Hyde::path('_pages/8450de2-test-page.blade.php');
    }

    protected function tearDown(): void
    {
        if (file_exists($this->markdownPath)) {
            unlink($this->markdownPath);
        }

        if (file_exists($this->bladePath)) {
            unlink($this->bladePath);
        }

        parent::tearDown();
    }

    // Assert the command can run
    public function test_command_can_run()
    {
        $this->artisan('make:page "8450de2 test page"')->assertExitCode(0);
    }

    // Assert the command contains expected output
    public function test_command_output()
    {
        $this->artisan('make:page "8450de2 test page"')
            ->expectsOutputToContain('Creating a new page!')
            ->expectsOutputToContain('Created file '.$this->markdownPath);
    }

    // Assert the command allows the user to specify a page type
    public function test_command_allows_user_to_specify_page_type()
    {
        $this->artisan('make:page "8450de2 test page" --type=markdown')->assertExitCode(0);
        $this->artisan('make:page "8450de2 test page" --type=blade')->assertExitCode(0);
    }

    // Assert the type option is case-insensitive
    public function test_type_option_is_case_insensitive()
    {
        $this->artisan('make:page "8450de2 test page" --type=Markdown')->assertExitCode(0);
        $this->artisan('make:page "8450de2 test page" --type=Blade')->assertExitCode(0);
    }

    // Assert that the command fails if the user specifies an invalid page type
    public function test_command_fails_if_user_specifies_invalid_page_type()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Invalid page type: invalid');
        $this->expectExceptionCode(400);
        $this->artisan('make:page "8450de2 test page" --type=invalid')->assertExitCode(400);
    }

    // Assert the command creates the markdown file
    public function test_command_creates_markdown_file()
    {
        $this->artisan('make:page "8450de2 test page"')->assertExitCode(0);

        $this->assertFileExists($this->markdownPath);
    }

    // Assert the command creates the blade file
    public function test_command_creates_blade_file()
    {
        $this->artisan('make:page "8450de2 test page" --type="blade"')->assertExitCode(0);

        $this->assertFileExists($this->bladePath);
    }

    // Assert the command fails if the file already exists
    public function test_command_fails_if_file_already_exists()
    {
        file_put_contents($this->markdownPath, 'This should not be overwritten');

        $this->expectException(Exception::class);
        $this->expectExceptionMessage("File $this->markdownPath already exists!");
        $this->expectExceptionCode(409);
        $this->artisan('make:page "8450de2 test page"')->assertExitCode(409);

        $this->assertEquals('This should not be overwritten', file_get_contents($this->markdownPath));
    }

    // Assert the command overwrites existing files when the force option is used
    public function test_command_overwrites_existing_files_when_force_option_is_used()
    {
        file_put_contents($this->markdownPath, 'This should be overwritten');

        $this->artisan('make:page "8450de2 test page" --force')->assertExitCode(0);

        $this->assertNotEquals('This should be overwritten', file_get_contents($this->markdownPath));
    }
}
