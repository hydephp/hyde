<?php

namespace Tests\Feature\Services;

use Hyde\Framework\Hyde;
use Hyde\Framework\Models\BladePage;
use Hyde\Framework\Models\DocumentationPage;
use Hyde\Framework\Models\MarkdownPage;
use Hyde\Framework\Models\MarkdownPost;
use Hyde\Framework\Services\CollectionService;
use Tests\TestCase;

class CollectionServiceTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        // backupDirectory(Hyde::path('_docs'));
        // deleteDirectory(Hyde::path('_docs'));
    }

    public function test_class_exists()
    {
        $this->assertTrue(class_exists(CollectionService::class));
    }

    public function test_get_source_file_list_for_model_method()
    {
        $this->testListUnit(BladePage::class, '_pages/a8a7b7ce.blade.php');
        $this->testListUnit(MarkdownPage::class, '_pages/a8a7b7ce.md');
        $this->testListUnit(MarkdownPost::class, '_posts/a8a7b7ce.md');
        $this->testListUnit(DocumentationPage::class, '_docs/a8a7b7ce.md');

        $this->assertFalse(CollectionService::getSourceFileListForModel('NonExistentModel'));
    }

    public function test_get_media_asset_files()
    {
        $this->assertTrue(is_array(CollectionService::getMediaAssetFiles()));
    }

    private function testListUnit(string $model, string $path)
    {
        touch(Hyde::path($path));

        $expected = str_replace(['.md', '.blade.php'], '', basename($path));

        $this->assertContains($expected, CollectionService::getSourceFileListForModel($model));

        unlink(Hyde::path($path));
    }

    public function tearDown(): void
    {
        // restoreDirectory(Hyde::path('_docs'));

        parent::tearDown();
    }
}
