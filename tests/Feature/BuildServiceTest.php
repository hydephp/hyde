<?php

namespace Tests\Feature;

use Hyde\Framework\DocumentationPageParser;
use Hyde\Framework\MarkdownPageParser;
use Hyde\Framework\MarkdownPostParser;
use Hyde\Framework\Models\BladePage;
use Hyde\Framework\Models\DocumentationPage;
use Hyde\Framework\Models\MarkdownPage;
use Hyde\Framework\Models\MarkdownPost;
use Hyde\Framework\Services\BuildService;
use Tests\Setup\MockContentSourceFiles;
use Tests\TestCase;

class BuildServiceTest extends TestCase
{
    use MockContentSourceFiles;

    public function test_find_model_from_file_path()
    {
        $this->assertEquals(MarkdownPage::class, BuildService::findModelFromFilePath('_pages/test.md'));
        $this->assertEquals(MarkdownPost::class, BuildService::findModelFromFilePath('_posts/test.md'));
        $this->assertEquals(DocumentationPage::class, BuildService::findModelFromFilePath('_docs/test.md'));
        $this->assertEquals(BladePage::class, BuildService::findModelFromFilePath('_pages/test.blade.php'));

        $this->assertFalse(BuildService::findModelFromFilePath('_foo/test.txt'));
    }

    public function test_get_parser_class_for_model()
    {
        $this->assertEquals(MarkdownPageParser::class, BuildService::getParserClassForModel(MarkdownPage::class));
        $this->assertEquals(MarkdownPostParser::class, BuildService::getParserClassForModel(MarkdownPost::class));
        $this->assertEquals(DocumentationPageParser::class, BuildService::getParserClassForModel(DocumentationPage::class));
        $this->assertEquals(BladePage::class, BuildService::getParserClassForModel(BladePage::class));
    }

    public function test_get_parser_instance_for_model()
    {
        $this->createContentSourceTestFiles();

        $this->assertInstanceOf(MarkdownPageParser::class, BuildService::getParserInstanceForModel(MarkdownPage::class, 'test'));
        $this->assertInstanceOf(MarkdownPostParser::class, BuildService::getParserInstanceForModel(MarkdownPost::class, 'test'));
        $this->assertInstanceOf(DocumentationPageParser::class, BuildService::getParserInstanceForModel(DocumentationPage::class, 'test'));
        $this->assertInstanceOf(BladePage::class, BuildService::getParserInstanceForModel(BladePage::class, 'test'));

        $this->deleteContentSourceTestFiles();
    }

    public function test_get_file_extension_for_model_files()
    {
        $this->assertEquals('.md', BuildService::getFileExtensionForModelFiles(MarkdownPage::class));
        $this->assertEquals('.md', BuildService::getFileExtensionForModelFiles(MarkdownPost::class));
        $this->assertEquals('.md', BuildService::getFileExtensionForModelFiles(DocumentationPage::class));
        $this->assertEquals('.blade.php', BuildService::getFileExtensionForModelFiles(BladePage::class));
    }

    public function test_get_file_path_for_model_class_files()
    {
        $this->assertEquals('_posts', BuildService::getFilePathForModelClassFiles(MarkdownPost::class));
        $this->assertEquals('_pages', BuildService::getFilePathForModelClassFiles(MarkdownPage::class));
        $this->assertEquals('_docs', BuildService::getFilePathForModelClassFiles(DocumentationPage::class));
        $this->assertEquals('_pages', BuildService::getFilePathForModelClassFiles(BladePage::class));
    }

    public function test_create_clickable_filepath()
    {
        $filename = 'be2329d7-3596-48f4-b5b8-deff352246a9';
        touch($filename);
        $output = BuildService::createClickableFilepath($filename);
        $this->assertStringContainsString('file://', $output);
        $this->assertStringContainsString($filename, $output);
        unlink($filename);
    }
}
