<?php

namespace Tests\Feature;

use Hyde\Framework\Actions\CreatesDefaultDirectories;
use Hyde\Framework\Hyde;
use Hyde\Framework\Models\BladePage;
use Hyde\Framework\Models\DocumentationPage;
use Hyde\Framework\Models\MarkdownPage;
use Hyde\Framework\Models\MarkdownPost;
use Hyde\Framework\StaticPageBuilder;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\File;
use Tests\TestCase;

/**
 * Feature tests for the StaticPageBuilder class.
 *
 * @covers \Hyde\Framework\StaticPageBuilder
 */
class StaticPageBuilderTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        // Back up any existing files
        backupDirectory(Hyde::path('_site'));

        // Clean the site directory
        File::deleteDirectory(Hyde::path('_site'));

        // Recreate the default directories
        (new CreatesDefaultDirectories)->__invoke();
    }

    protected function tearDown(): void
    {
        // Restore the file environment and any backed up files
        restoreDirectory(Hyde::path('_site'));

        parent::tearDown();
    }

    protected function validateBasicHtml(string $html)
    {
        $this->assertStringContainsString('<!DOCTYPE html>', $html);
        $this->assertStringContainsString('<html lang="en">', $html);
        $this->assertStringContainsString('<head>', $html);
        $this->assertStringContainsString('<title>', $html);
        $this->assertStringContainsString('</title>', $html);
        $this->assertStringContainsString('</head>', $html);
        $this->assertStringContainsString('<body', $html);
        $this->assertStringContainsString('</body>', $html);
        $this->assertStringContainsString('</html>', $html);
    }

    public function test_can_build_blade_page()
    {
        file_put_contents(BladePage::$sourceDirectory.'/foo.blade.php', 'bar');

        $page = new BladePage('foo');

        new StaticPageBuilder($page, true);

        $this->assertFileExists(Hyde::path('_site/foo.html'));
        $this->assertStringEqualsFile(Hyde::path('_site/foo.html'), 'bar');

        unlink(BladePage::$sourceDirectory.'/foo.blade.php');
    }

    public function test_can_build_markdown_post()
    {
        $page = new MarkdownPost([
            'title' => 'foo',
            'author' => 'bar',
        ], '# Body', 'Title', 'foo');

        new StaticPageBuilder($page, true);

        $this->assertFileExists(Hyde::path('_site/posts/foo.html'));
        $this->validateBasicHtml(file_get_contents(Hyde::path('_site/posts/foo.html')));
    }

    public function test_can_build_markdown_page()
    {
        $page = new MarkdownPage([], '# Body', 'Title', 'foo');

        new StaticPageBuilder($page, true);

        $this->assertFileExists(Hyde::path('_site/foo.html'));
        $this->validateBasicHtml(file_get_contents(Hyde::path('_site/foo.html')));
    }

    public function test_can_build_documentation_page()
    {
        $page = new DocumentationPage([], '# Body', 'Title', 'foo');

        new StaticPageBuilder($page, true);

        $this->assertFileExists(Hyde::path('_site/'.Hyde::docsDirectory().'/foo.html'));
        $this->validateBasicHtml(file_get_contents(Hyde::path('_site/'.Hyde::docsDirectory().'/foo.html')));
    }

    public function test_creates_custom_documentation_directory()
    {
        $page = new DocumentationPage([], '# Body', 'Title', 'foo');

        Config::set('hyde.docsDirectory', 'docs/foo');

        new StaticPageBuilder($page, true);

        $this->assertFileExists(Hyde::path('_site/docs/foo/foo.html'));
        $this->validateBasicHtml(file_get_contents(Hyde::path('_site/docs/foo/foo.html')));
    }
}
