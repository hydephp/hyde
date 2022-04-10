<?php

namespace Tests\Feature;

use Hyde\Framework\StaticPageBuilder;
use Tests\TestCase;

/**
 * @todo Implement the test.
 *
 * Feature tests for the StaticPageBuilder class.
 *
 * @see \Hyde\Framework\StaticPageBuilder
 *
 * The compiled HTML is tested in a separate unit test.
 * @see \Tests\Unit\ViewCompilerTest
 */
class StaticPageBuilderTest extends TestCase
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

    public function test_can_build_markdown_post()
    {
        $this->markTestIncomplete();

        // Run the builder

        // Make the assertions

        // Clean up after the test
    }

    public function test_can_build_markdown_page()
    {
        $this->markTestIncomplete();

        // Run the builder

        // Make the assertions

        // Clean up after the test
    }

    public function test_can_build_blade_page()
    {
        $this->markTestIncomplete();

        // Run the builder

        // Make the assertions

        // Clean up after the test
    }

    public function test_can_build_documentation_page()
    {
        $this->markTestIncomplete();

        // Run the builder

        // Make the assertions

        // Clean up after the test
    }
}
