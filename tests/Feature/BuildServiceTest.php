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

    public function testFindModelFromFilePath()
    {
        $this->assertEquals(MarkdownPost::class, BuildService::findModelFromFilePath('_posts/test.md'));
        $this->assertEquals(MarkdownPage::class, BuildService::findModelFromFilePath('_pages/test.md'));
        $this->assertEquals(DocumentationPage::class, BuildService::findModelFromFilePath('_docs/test.md'));
        $this->assertEquals(BladePage::class, BuildService::findModelFromFilePath('resources/views/pages/test.md'));

        $this->assertFalse(BuildService::findModelFromFilePath('foo/bar/test.md'));
    }

    public function testGetParserClassForModel()
    {
        $this->assertEquals(MarkdownPageParser::class, BuildService::getParserClassForModel(MarkdownPage::class));
        $this->assertEquals(MarkdownPostParser::class, BuildService::getParserClassForModel(MarkdownPost::class));
        $this->assertEquals(DocumentationPageParser::class, BuildService::getParserClassForModel(DocumentationPage::class));
        $this->assertEquals(BladePage::class, BuildService::getParserClassForModel(BladePage::class));

        $this->assertFalse(BuildService::getParserClassForModel('foo/bar'));
    }

    public function testGetParserInstanceForModel()
    {
        $this->createContentSourceTestFiles();

        $this->assertInstanceOf(MarkdownPageParser::class, BuildService::getParserInstanceForModel(MarkdownPage::class, 'test'));
        $this->assertInstanceOf(MarkdownPostParser::class, BuildService::getParserInstanceForModel(MarkdownPost::class, 'test'));
        $this->assertInstanceOf(DocumentationPageParser::class, BuildService::getParserInstanceForModel(DocumentationPage::class, 'test'));
        $this->assertInstanceOf(BladePage::class, BuildService::getParserInstanceForModel(BladePage::class, 'test'));

        $this->assertFalse(BuildService::getParserInstanceForModel('foo/bar', 'test'));

        $this->deleteContentSourceTestFiles();
    }

    public function testGetFileExtensionForModelFiles()
    {
        $this->assertEquals('.md', BuildService::getFileExtensionForModelFiles(MarkdownPage::class));
        $this->assertEquals('.md', BuildService::getFileExtensionForModelFiles(MarkdownPost::class));
        $this->assertEquals('.md', BuildService::getFileExtensionForModelFiles(DocumentationPage::class));
        $this->assertEquals('.blade.php', BuildService::getFileExtensionForModelFiles(BladePage::class));

        $this->assertFalse(BuildService::getFileExtensionForModelFiles('foo/bar'));
    }

    public function testGetFilePathForModelClassFiles()
    {
        $this->assertEquals('_posts', BuildService::getFilePathForModelClassFiles(MarkdownPost::class));
        $this->assertEquals('_pages', BuildService::getFilePathForModelClassFiles(MarkdownPage::class));
        $this->assertEquals('_docs', BuildService::getFilePathForModelClassFiles(DocumentationPage::class));
        $this->assertEquals('resources/views/pages', BuildService::getFilePathForModelClassFiles(BladePage::class));

        $this->assertFalse(BuildService::getFilePathForModelClassFiles('foo/bar'));
    }

    public function testCreateClickableFilepath()
    {
        $filename = 'be2329d7-3596-48f4-b5b8-deff352246a9';
        touch($filename);
        $output = BuildService::createClickableFilepath($filename);
        $this->assertStringContainsString('file://', $output);
        $this->assertStringContainsString($filename, $output);
        unlink($filename);
    }
}
