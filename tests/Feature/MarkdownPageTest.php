<?php

namespace Tests\Feature;

use Hyde\Framework\Hyde;
use Hyde\Framework\MarkdownPageParser;
use Hyde\Framework\Models\MarkdownPage;
use Hyde\Framework\Services\CollectionService;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

class MarkdownPageTest extends TestCase
{
    /**
     * Test the Parser.
     */
    public function test_can_get_collection_of_slugs()
    {
        File::deleteDirectory(Hyde::path('_pages'));
        mkdir(Hyde::path('_pages'));
        file_put_contents(Hyde::path('_pages/phpunit-test.md'), "# PHPUnit Test File \n Hello World!");

        $array = CollectionService::getMarkdownPageList();

        $this->assertIsArray($array);
        $this->assertCount(1, $array);
        $this->assertArrayHasKey('phpunit-test', array_flip($array));
    }

    public function test_exception_is_thrown_for_missing_slug()
    {
        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('File _pages/invalid-file.md not found.');
        new MarkdownPageParser('invalid-file');
    }

    public function test_can_parse_documentation_page()
    {
        $parser = new MarkdownPageParser('phpunit-test');
        $this->assertInstanceOf(MarkdownPageParser::class, $parser);
    }

    public function test_title_was_inferred_from_heading()
    {
        $parser = new MarkdownPageParser('phpunit-test');
        $this->assertIsString($parser->title);
        $this->assertEquals('PHPUnit Test File', $parser->title);
    }

    public function test_parser_contains_body_text()
    {
        $parser = new MarkdownPageParser('phpunit-test');
        $this->assertIsString($parser->body);
        $this->assertEquals("# PHPUnit Test File \n Hello World!", $parser->body);
    }

    /**
     * Test the Model.
     */
    public function test_can_get_page_model_object()
    {
        $parser = new MarkdownPageParser('phpunit-test');
        $object = $parser->get();
        $this->assertInstanceOf(MarkdownPage::class, $object);

        return $object;
    }

    /**
     * @depends test_can_get_page_model_object
     */
    public function test_created_model_contains_expected_data(MarkdownPage $object)
    {
        $this->assertEquals('PHPUnit Test File', $object->title);
        $this->assertEquals("# PHPUnit Test File \n Hello World!", $object->body);
        $this->assertEquals('phpunit-test', $object->slug);
    }
}
