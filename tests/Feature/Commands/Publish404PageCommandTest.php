<?php

namespace Tests\Feature\Commands;

use App\Hyde\Hyde;
use Tests\TestCase;

class Publish404PageCommandTest extends TestCase
{
	/**
     * Set up the tests by making sure no conflicting files exist.
     * @return void
     */
    protected function setUp(): void
    {
        $this->unlink();
		
        parent::setUp();
    }

	/**
     * Clean up after tests by removing the created files.
     * @return void
     */
    protected function tearDown(): void
    {
        $this->unlink();

        parent::tearDown();
    }

	private function unlink(): void
	{
		if (file_exists($this->getBladePath())) {
			unlink($this->getBladePath());
		}
		if (file_exists($this->getMarkdownPath())) {
			unlink($this->getMarkdownPath());
		}
	}

	private function getBladePath(): string
	{
		return Hyde::path('resources/views/pages/404.blade.php');
	}

	private function getMarkdownPath(): string
	{
		return Hyde::path('_pages/404.md');
	}

    public function test_command_exists()
    {
		$this->artisan('publish:404 --help')->assertExitCode(0);
		$this->assertCommandCalled('publish:404 --help');
    }

	public function test_command_creates_blade_file()
	{
		$path = $this->getBladePath();

		// Assert that no old file exists which would cause issues
		$this->assertFileDoesNotExist($path);

		$this->artisan('publish:404 --type="blade" --no-interaction')
			->expectsOutput("Created file $path!")
			->assertExitCode(0);

		$this->assertFileExists($path);
	}
	
	public function test_command_creates_markdown_file()
	{
		$path = $this->getMarkdownPath();

		// Assert that no old file exists which would cause issues
		$this->assertFileDoesNotExist($path);

		$this->artisan('publish:404 --type="markdown" --no-interaction')
			->expectsOutput("Created file $path!")
			->assertExitCode(0);

		$this->assertFileExists($path);
	}

	public function test_command_does_not_accept_invalid_type()
	{
		$this->artisan('publish:404 --type="invalid-type"')
			->expectsOutput('Type `invalid-type` is not valid. It must be either `blade` or `markdown`')
			->assertExitCode(400);

		$this->artisan('publish:404')
			->expectsQuestion('Which type of view would you like to publish?', 'invalid-type')
			->expectsOutput('Type `invalid-type` is not valid. It must be either `blade` or `markdown`')
			->assertExitCode(400);
	}

	public function test_command_does_not_overwrite_existing_files()
	{
		$path = $this->getMarkdownPath();

		file_put_contents($path, "Test File");

		// Assert that the created file exists
		$this->assertFileExists($path);
		
		$this->artisan('publish:404 --type="markdown" --no-interaction')
			->expectsOutput("File $path already exists!")
			->assertExitCode(409);

		// Assert the file contents were not overwritten
		$this->assertStringContainsString('Test File',
            file_get_contents($path));
	}

	public function test_command_does_overwrite_existing_files_when_force_flag_is_set()
	{
		$path = $this->getMarkdownPath();

		file_put_contents($path, "Test File");

		// Assert that the created file exists
		$this->assertFileExists($path);
		
		$this->artisan('publish:404 --type="markdown" --force --no-interaction')
			->expectsOutput("Created file $path!")
			->assertExitCode(0);

		// Assert the file contents were overwritten
		$this->assertStringNotContainsString('Test File',
            file_get_contents($path));
	}

	public function test_command_is_interactive_and_uses_the_supplied_answer()
	{
		$markdownPath = $this->getMarkdownPath();
		$bladePath = $this->getBladePath();

		$this->artisan('publish:404')
			->expectsQuestion('Which type of view would you like to publish?', 'Markdown')
			->expectsOutput("Created file $markdownPath!")
			->doesntExpectOutput("Created file $bladePath!")
			->assertExitCode(0);
	}
}