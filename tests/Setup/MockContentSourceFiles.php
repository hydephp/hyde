<?php

namespace Tests\Setup;

use Hyde\Framework\Hyde;
use Hyde\Framework\Models\BladePage;
use Hyde\Framework\Models\DocumentationPage;
use Hyde\Framework\Models\MarkdownPage;
use Hyde\Framework\Models\MarkdownPost;
use Hyde\Framework\Services\BuildService;

trait MockContentSourceFiles
{
    public function createContentSourceTestFiles()
    {
        touch(Hyde::path(BuildService::getFilePathForModelClassFiles(MarkdownPost::class).'/test.md'));
        touch(Hyde::path(BuildService::getFilePathForModelClassFiles(MarkdownPage::class).'/test.md'));
        touch(Hyde::path(BuildService::getFilePathForModelClassFiles(DocumentationPage::class).'/test.md'));
        touch(Hyde::path(BuildService::getFilePathForModelClassFiles(BladePage::class).'/test.blade.php'));
    }

    public function deleteContentSourceTestFiles()
    {
        unlink(Hyde::path(BuildService::getFilePathForModelClassFiles(MarkdownPost::class).'/test.md'));
        unlink(Hyde::path(BuildService::getFilePathForModelClassFiles(MarkdownPage::class).'/test.md'));
        unlink(Hyde::path(BuildService::getFilePathForModelClassFiles(DocumentationPage::class).'/test.md'));
        unlink(Hyde::path(BuildService::getFilePathForModelClassFiles(BladePage::class).'/test.blade.php'));
    }
}
