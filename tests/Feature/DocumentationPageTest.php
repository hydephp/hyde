<?php

namespace Tests\Feature;

use Exception;
use Hyde\Framework\DocumentationPageParser;
use Hyde\Framework\Hyde;
use Hyde\Framework\Models\DocumentationPage;
use Hyde\Framework\Services\CollectionService;
use Tests\TestCase;

class DocumentationPageTest extends TestCase
{
    /**
     * Test the Parser.
     */
    public function test_can_get_collection_of_slugs()
    {
        deleteDirectory(Hyde::path('_docs'));
        mkdir(Hyde::path('_docs'));
        file_put_contents(Hyde::path('_docs/phpunit-test.md'), "# PHPUnit Test File \n Hello World!");

        $array = CollectionService::getDocumentationPageList();

        $this->assertIsArray($array);
        $this->assertCount(1, $array);
        $this->assertArrayHasKey('phpunit-test', array_flip($array));
    }

    public function test_exception_is_thrown_for_missing_slug()
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('File _docs/invalid-file.md not found.');
        new DocumentationPageParser('invalid-file');
    }

    public function test_can_parse_documentation_page()
    {
        $parser = new DocumentationPageParser('phpunit-test');
        $this->assertInstanceOf(DocumentationPageParser::class, $parser);
    }

    public function test_title_was_inferred_from_heading()
    {
        $parser = new DocumentationPageParser('phpunit-test');
        $this->assertIsString($parser->title);
        $this->assertEquals('PHPUnit Test File', $parser->title);
    }

    public function test_parser_contains_body_text()
    {
        $parser = new DocumentationPageParser('phpunit-test');
        $this->assertIsString($parser->body);
        $this->assertEquals("# PHPUnit Test File \n Hello World!", $parser->body);
    }

    /**
     * Test the Model.
     */
    public function test_can_get_page_model_object(): DocumentationPage
    {
        $parser = new DocumentationPageParser('phpunit-test');
        $object = $parser->get();
        $this->assertInstanceOf(DocumentationPage::class, $object);

        return $object;
    }

    /**
     * @depends test_can_get_page_model_object
     */
    public function test_created_model_contains_expected_data(DocumentationPage $object)
    {
        $this->assertEquals('PHPUnit Test File', $object->title);
        $this->assertEquals("# PHPUnit Test File \n Hello World!", $object->body);
        $this->assertEquals('phpunit-test', $object->slug);
    }
}
