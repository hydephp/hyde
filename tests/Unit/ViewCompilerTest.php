<?php

namespace Tests\Unit;

use Tests\TestCase;

/**
 * @todo Implement the test.
 */
class ViewCompilerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Back up any existing files
    }

    protected function tearDown(): void
    {
        // Restore the file environment and any backed up files

        parent::tearDown();
    }

    protected function validateBasicHtml(string $html)
    {
        $this->assertStringContainsString('<!DOCTYPE html>', $html);
        $this->assertStringContainsString('<html lang="en">', $html);
        $this->assertStringContainsString('<head>', $html);
        $this->assertStringContainsString('<title>', $html);
        $this->assertStringContainsString('</title>', $html);
        $this->assertStringContainsString('</head>', $html);
        $this->assertStringContainsString('<body>', $html);
        $this->assertStringContainsString('</body>', $html);
        $this->assertStringContainsString('</html>', $html);
    }

    public function test_compiled_index_file_is_valid()
    {
        $this->markTestIncomplete();
        // Create the test file

        // $this->validateBasicHtml($stream)

        // Run any specific assertions

        // Clean up after the test
    }

    public function test_compiled_post_file_is_valid()
    {
        $this->markTestIncomplete();
        // Create the test file

        // $this->validateBasicHtml($stream)

        // Run any specific assertions

        // Clean up after the test
    }

    public function test_compiled_markdown_page_file_is_valid()
    {
        $this->markTestIncomplete();
        // Create the test file

        // $this->validateBasicHtml($stream)

        // Run any specific assertions

        // Clean up after the test
    }

    public function test_compiled_blade_page_file_is_valid()
    {
        $this->markTestIncomplete();
        // Create the test file

        // $this->validateBasicHtml($stream)

        // Run any specific assertions

        // Clean up after the test
    }

    public function test_compiled_documentation_file_is_valid()
    {
        $this->markTestIncomplete();
        // Create the test file

        // $this->validateBasicHtml($stream)

        // Run any specific assertions

        // Clean up after the test
    }
}
