<?php

namespace Tests\Feature;

use Hyde\Framework\Actions\GeneratesDocumentationSidebar;
use Hyde\Framework\Hyde;
use Tests\TestCase;

class GeneratesDocumentationSidebarTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        deleteDirectory(Hyde::path('_docs'));
        mkdir(Hyde::path('_docs'));

        touch(Hyde::path('_docs/generates_documentation_sidebar_test1.md'));
        touch(Hyde::path('_docs/generates_documentation_sidebar_test2.md'));
        touch(Hyde::path('_docs/generates_documentation_sidebar_test3.md'));
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        deleteDirectory(Hyde::path('_docs'));
        mkdir(Hyde::path('_docs'));

        parent::tearDown();
    }

    public function test_get_method_returns_array()
    {
        $array = GeneratesDocumentationSidebar::get();

        $this->assertIsArray($array);
        $this->assertCount(3, $array);
    }
}
