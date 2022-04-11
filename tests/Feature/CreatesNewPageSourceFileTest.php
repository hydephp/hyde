<?php

namespace Tests\Feature;

use Exception;
use Hyde\Framework\Actions\CreatesNewPageSourceFile;
use Hyde\Framework\Hyde;
use Hyde\Framework\Models\BladePage;
use Tests\TestCase;

class CreatesNewPageSourceFileTest extends TestCase
{
    // Tear down the test
    protected function tearDown(): void
    {
        if (file_exists(Hyde::path('_pages/682072b-test-page.md'))) {
            unlink(Hyde::path('_pages/682072b-test-page.md'));
        }

        if (file_exists(Hyde::path('_pages/682072b-test-page.blade.php'))) {
            unlink(Hyde::path('_pages/682072b-test-page.blade.php'));
        }

        parent::tearDown();
    }

    // Test that the class can be instantiated
    public function test_class_can_be_instantiated()
    {
        $this->assertInstanceOf(
            CreatesNewPageSourceFile::class,
            new CreatesNewPageSourceFile('682072b Test Page')
        );
    }

    // Test that a slug is generated from the title
    public function test_that_a_slug_is_generated_from_the_title()
    {
        $this->assertEquals(
            '682072b-test-page',
            (new CreatesNewPageSourceFile('682072b Test Page'))->slug
        );
    }

    // Test that an exception is thrown if the page type is not 'markdown' or 'blade'
    public function test_that_an_exception_is_thrown_if_the_page_type_is_not_markdown_or_blade()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('The page type must be either "markdown" or "blade"');

        (new CreatesNewPageSourceFile('682072b Test Page', 'invalid'));
    }

    // Test that a Markdown file can be created
    public function test_that_a_markdown_file_can_be_created_and_contains_expected_content()
    {
        // Create the page
        (new CreatesNewPageSourceFile('682072b Test Page'));

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
        (new CreatesNewPageSourceFile('682072b Test Page', BladePage::class));

        // Check that the file exists
        $this->assertFileExists(
            Hyde::path('_pages/682072b-test-page.blade.php')
        );

        // Check that the file contains the expected content
        $fileContent = file_get_contents(Hyde::path('_pages/682072b-test-page.blade.php'));
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

    // Test that the file path can be returned
    public function test_that_the_file_path_can_be_returned()
    {
        $this->assertEquals(
            Hyde::path('_pages/682072b-test-page.md'),
            (new CreatesNewPageSourceFile('682072b Test Page'))->path
        );

        $this->assertEquals(
            Hyde::path('_pages/682072b-test-page.blade.php'),
            (new CreatesNewPageSourceFile('682072b Test Page', BladePage::class))->path
        );
    }
}
