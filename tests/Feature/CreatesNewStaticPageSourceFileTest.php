<?php

namespace Tests\Feature;

use Hyde\Framework\Actions\CreatesNewStaticPageSourceFile;
use Hyde\Framework\Hyde;
use Hyde\Framework\Models\BladePage;
use PHPUnit\Framework\TestCase;

class CreatesNewStaticPageSourceFileTest extends TestCase
{
	// Tear down the test
	protected function tearDown(): void
	{
		if (file_exists(Hyde::path('_pages/682072b-test-page.md'))) {
			unlink(Hyde::path('_pages/682072b-test-page.md'));
		}

		if (file_exists(Hyde::path('resources/views/pages/682072b-test-page.blade.php'))) {
			unlink(Hyde::path('resources/views/pages/682072b-test-page.blade.php'));
		}

		parent::tearDown();
	}

	// Test that the class can be instantiated
	public function test_class_can_be_instantiated()
	{
		$this->assertInstanceOf(
			CreatesNewStaticPageSourceFile::class,
			new CreatesNewStaticPageSourceFile('682072b Test Page')
		);
	}

	// Test that a slug is generated from the title
	public function test_that_a_slug_is_generated_from_the_title()
	{
		$this->assertEquals(
			'682072b-test-page',
			(new CreatesNewStaticPageSourceFile('682072b Test Page'))->slug
		);
	}

	// Test that an exception is thrown if the page type is not 'markdown' or 'blade'
	public function test_that_an_exception_is_thrown_if_the_page_type_is_not_markdown_or_blade()
	{
		$this->expectException(\Exception::class);
		$this->expectExceptionMessage('The page type must be either "markdown" or "blade"');

		(new CreatesNewStaticPageSourceFile('682072b Test Page', 'invalid'))->createPage('invalid');
	}

	// Test that a Markdown file can be created
	public function test_that_a_markdown_file_can_be_created_and_contains_expected_content()
	{
		// Create the page
		(new CreatesNewStaticPageSourceFile('682072b Test Page'))->createMarkdownFile();

		// Check that the file exists
		$this->assertFileExists(
			Hyde::path('_pages/682072b-test-page.md')
		);

		// Check that the file contains the expected content
		$this->assertEquals(
			"---\ntitle: 682072b Test Page\n---\n\n# 682072b Test Page\n",
			file_get_contents(Hyde::path('_pages/682072b-test-page.md'))
		);
	}

	// Test that a Blade file can be created
	public function test_that_a_blade_file_can_be_created_and_contains_expected_content()
	{
		// Create the page
		(new CreatesNewStaticPageSourceFile('682072b Test Page', BladePage::class))->createBladeFile();

		// Check that the file exists
		$this->assertFileExists(
			Hyde::path('resources/views/pages/682072b-test-page.blade.php')
		);

		// Check that the file contains the expected content
		$fileContent = file_get_contents(Hyde::path('resources/views/pages/682072b-test-page.blade.php'));
		$this->assertStringContainsString(
			'@extends(\'hyde::layouts.app\')',
			$fileContent
		);
		$this->assertStringContainsString(
			'@php($title = "682072b Test Page")',
			$fileContent
		);
		$this->assertStringContainsString(
			'<h1 class="text-center text-3xl font-bold">682072b Test Page</h1>',
			$fileContent
		);
	}
}
