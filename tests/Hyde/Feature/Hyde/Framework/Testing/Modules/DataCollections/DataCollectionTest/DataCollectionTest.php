<?php

namespace Hyde\Framework\Testing\Modules\DataCollections\DataCollectionTest;

use Hyde\Framework\Hyde;
use Hyde\Framework\Models\MarkdownDocument;
use Hyde\Framework\Modules\DataCollections\DataCollection;
use Hyde\Framework\Modules\DataCollections\DataCollectionServiceProvider;
use Hyde\Framework\Modules\DataCollections\Facades\MarkdownCollection;
use Hyde\Testing\TestCase;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\File;

/**
 * @covers \Hyde\Framework\Modules\DataCollections\DataCollection
 * @covers \Hyde\Framework\Modules\DataCollections\DataCollectionServiceProvider
 * @covers \Hyde\Framework\Modules\DataCollections\Facades\MarkdownCollection
 */
class DataCollectionTest extends TestCase
{
    // constructor creates new data collection instance
    public function test_constructor_creates_new_data_collection_instance()
    {
        $class = new DataCollection('foo');
        $this->assertInstanceOf(DataCollection::class, $class);
        $this->assertInstanceOf(Collection::class, $class);
    }

    public function test_constructor_sets_key()
    {
        $class = new DataCollection('foo');
        $this->assertEquals('foo', $class->key);
    }

    public function test_key_is_required()
    {
        $this->expectException(\ArgumentCountError::class);
        new DataCollection();
    }

    public function test_get_collection_method_returns_the_collection_instance()
    {
        $class = new DataCollection('foo');
        $this->assertSame($class, $class->getCollection());
    }

    public function test_get_collection_method_sets_parse_time_in_ms()
    {
        $class = new DataCollection('foo');
        $class->getCollection();
        $this->assertIsFloat($class->parseTimeInMs);
    }

    public function test_get_markdown_files_method_returns_empty_array_if_the_specified_directory_does_not_exist()
    {
        $class = new DataCollection('foo');
        $this->assertIsArray($class->getMarkdownFiles());
        $this->assertEmpty($class->getMarkdownFiles());
    }

    public function test_get_markdown_files_method_returns_empty_array_if_no_files_are_found_in_specified_directory()
    {
        mkdir(Hyde::path('_data/foo'));
        $class = new DataCollection('foo');
        $this->assertIsArray($class->getMarkdownFiles());
        $this->assertEmpty($class->getMarkdownFiles());
        rmdir(Hyde::path('_data/foo'));
    }

    public function test_get_markdown_files_method_returns_an_array_of_markdown_files_in_the_specified_directory()
    {
        mkdir(Hyde::path('_data/foo'));
        touch(Hyde::path('_data/foo/foo.md'));
        touch(Hyde::path('_data/foo/bar.md'));

        $this->assertEquals([
            Hyde::path('_data/foo/bar.md'),
            Hyde::path('_data/foo/foo.md'),
        ], (new DataCollection('foo'))->getMarkdownFiles());

        File::deleteDirectory(Hyde::path('_data/foo'));
    }

    public function test_get_markdown_files_method_does_not_include_files_in_subdirectories()
    {
        mkdir(Hyde::path('_data/foo'));
        mkdir(Hyde::path('_data/foo/bar'));
        touch(Hyde::path('_data/foo/foo.md'));
        touch(Hyde::path('_data/foo/bar/bar.md'));
        $this->assertEquals([
            Hyde::path('_data/foo/foo.md'),
        ], (new DataCollection('foo'))->getMarkdownFiles());
        File::deleteDirectory(Hyde::path('_data/foo'));
    }

    public function test_get_markdown_files_method_does_not_include_files_with_extensions_other_than_md()
    {
        mkdir(Hyde::path('_data/foo'));
        touch(Hyde::path('_data/foo/foo.md'));
        touch(Hyde::path('_data/foo/bar.txt'));
        $this->assertEquals([
            Hyde::path('_data/foo/foo.md'),
        ], (new DataCollection('foo'))->getMarkdownFiles());
        File::deleteDirectory(Hyde::path('_data/foo'));
    }

    public function test_static_markdown_helper_returns_new_data_collection_instance()
    {
        $this->assertInstanceOf(DataCollection::class, DataCollection::markdown('foo'));
    }

    public function test_static_markdown_helper_discovers_and_parses_markdown_files_in_the_specified_directory()
    {
        mkdir(Hyde::path('_data/foo'));
        touch(Hyde::path('_data/foo/foo.md'));
        touch(Hyde::path('_data/foo/bar.md'));

        $collection = DataCollection::markdown('foo');

        $this->assertContainsOnlyInstancesOf(MarkdownDocument::class, $collection);

        File::deleteDirectory(Hyde::path('_data/foo'));
    }

    public function test_static_markdown_helper_ignores_files_starting_with_an_underscore()
    {
        mkdir(Hyde::path('_data/foo'));
        touch(Hyde::path('_data/foo/foo.md'));
        touch(Hyde::path('_data/foo/_bar.md'));
        $this->assertCount(1, DataCollection::markdown('foo'));
        File::deleteDirectory(Hyde::path('_data/foo'));
    }

    public function test_markdown_facade_returns_same_result_as_static_markdown_helper()
    {
        $expected = DataCollection::markdown('foo');
        $actual = MarkdownCollection::get('foo');
        unset($expected->parseTimeInMs);
        unset($actual->parseTimeInMs);
        $this->assertEquals($expected, $actual);
    }

    // Test DataCollectionServiceProvider registers the facade as an alias
    public function test_data_collection_service_provider_registers_the_facade_as_an_alias()
    {
        $this->assertArrayHasKey('MarkdownCollection', AliasLoader::getInstance()->getAliases());
        $this->assertContains(MarkdownCollection::class, AliasLoader::getInstance()->getAliases());
    }

    public function test_data_collection_service_provider_creates_the__data_directory_if_it_does_not_exist()
    {
        File::deleteDirectory(Hyde::path('_data'));
        $this->assertFileDoesNotExist(Hyde::path('_data'));

        (new DataCollectionServiceProvider($this->app))->boot();

        $this->assertFileExists(Hyde::path('_data'));
    }

    public function test_class_has_static_source_directory_property()
    {
        $this->assertEquals('_data', DataCollection::$sourceDirectory);
    }

    public function test_source_directory_can_be_changed()
    {
        DataCollection::$sourceDirectory = 'foo';
        mkdir(Hyde::path('foo/bar'), recursive: true);
        touch(Hyde::path('foo/bar/foo.md'));
        $this->assertEquals([
            Hyde::path('foo/bar/foo.md'),
        ], (new DataCollection('bar'))->getMarkdownFiles());
        File::deleteDirectory(Hyde::path('foo'));
    }
}
