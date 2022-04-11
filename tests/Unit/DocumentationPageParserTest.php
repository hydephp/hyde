<?php

namespace Tests\Unit;

use Hyde\Framework\DocumentationPageParser;
use Hyde\Framework\Hyde;
use Hyde\Framework\Models\DocumentationPage;
use Tests\TestCase;

class DocumentationPageParserTest extends TestCase
{
    /**
     * Setup the test environment.
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

        file_put_contents(Hyde::path('_docs/test.md'), "# Title Heading \n\nMarkdown Content");
    }

    /**
     * Clean up the testing environment before the next test.
     *
     * @return void
     */
    protected function tearDown(): void
    {
        // Remove the published stub file
        unlink(Hyde::path('_docs/test.md'));

        parent::tearDown();
    }

    public function test_can_parse_markdown_file()
    {
        $page = (new DocumentationPageParser('test'))->get();
        $this->assertInstanceOf(DocumentationPage::class, $page);
    }
}
