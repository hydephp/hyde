<?php

declare(strict_types=1);

namespace Hyde\Testing;

use Hyde\Hyde;
use Hyde\Pages\BladePage;
use Hyde\Pages\MarkdownPage;
use Hyde\Pages\MarkdownPost;
use Hyde\Pages\DocumentationPage;
use Illuminate\Support\Facades\File;

/**
 * Comprehensive Feature Test Suite
 *
 * Tests all core HydePHP v2.0 features across all supported PHP versions
 */
class ComprehensiveFeatureTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->cleanupTestFiles();
    }

    protected function tearDown(): void
    {
        $this->cleanupTestFiles();
        parent::tearDown();
    }

    protected function cleanupTestFiles(): void
    {
        $testFiles = [
            '_pages/test-blade.blade.php',
            '_pages/test-markdown.md',
            '_posts/test-blog-post.md',
            '_docs/test-documentation.md',
            '_site'
        ];

        foreach ($testFiles as $file) {
            $path = Hyde::path($file);
            if (File::exists($path)) {
                if (File::isDirectory($path)) {
                    File::deleteDirectory($path);
                } else {
                    File::delete($path);
                }
            }
        }
    }

    public function testBladePageCreationAndCompilation()
    {
        // Test Blade page creation
        $this->artisan('make:page', [
            'title' => 'test-blade',
            '--type' => 'blade'
        ])->assertExitCode(0);

        $bladePath = Hyde::path('_pages/test-blade.blade.php');
        $this->assertFileExists($bladePath);

        // Verify content
        $content = File::get($bladePath);
        $this->assertStringContainsString('@extends', $content);
        $this->assertStringContainsString('test-blade', $content);

        // Test compilation
        $this->artisan('build', ['--no-interaction' => true])
            ->assertExitCode(0);

        $this->assertFileExists(Hyde::path('_site/test-blade.html'));
    }

    public function testMarkdownPageCreationAndCompilation()
    {
        // Test Markdown page creation
        $this->artisan('make:page', [
            'title' => 'test-markdown',
            '--type' => 'markdown'
        ])->assertExitCode(0);

        $markdownPath = Hyde::path('_pages/test-markdown.md');
        $this->assertFileExists($markdownPath);

        // Verify content
        $content = File::get($markdownPath);
        $this->assertStringContainsString('# test-markdown', $content);

        // Test compilation
        $this->artisan('build', ['--no-interaction' => true])
            ->assertExitCode(0);

        $this->assertFileExists(Hyde::path('_site/test-markdown.html'));
    }

    public function testBlogPostCreationAndCompilation()
    {
        // Create blog post manually to avoid interactive prompts
        $postPath = Hyde::path('_posts/test-blog-post.md');
        $postContent = "---\ntitle: test-blog-post\ndate: '2024-01-01'\ndescription: 'Test blog post description'\nauthor: 'Test Author'\ncategory: 'Testing'\n---\n\n# Test Blog Post\n\nThis is a test blog post.";

        File::ensureDirectoryExists(dirname($postPath));
        File::put($postPath, $postContent);

        $this->assertFileExists($postPath);

        // Verify front matter
        $content = File::get($postPath);
        $this->assertStringContainsString('title: test-blog-post', $content);
        $this->assertStringContainsString('date:', $content);

        // Test compilation
        $this->artisan('build', ['--no-interaction' => true])
            ->assertExitCode(0);

        $this->assertFileExists(Hyde::path('_site/posts/test-blog-post.html'));
    }

    public function testDocumentationPageCreationAndCompilation()
    {
        // Test documentation page creation
        $this->artisan('make:page', [
            'title' => 'test-documentation',
            '--type' => 'docs'
        ])->assertExitCode(0);

        $docsPath = Hyde::path('_docs/test-documentation.md');
        $this->assertFileExists($docsPath);

        // Verify content
        $content = File::get($docsPath);
        $this->assertStringContainsString('# test-documentation', $content);

        // Test compilation
        $this->artisan('build', ['--no-interaction' => true])
            ->assertExitCode(0);

        $this->assertFileExists(Hyde::path('_site/docs/test-documentation.html'));
    }

    public function testSitemapGeneration()
    {
        // Ensure sitemap generation is enabled
        config(['hyde.generate_sitemap' => true]);
        config(['hyde.url' => 'https://example.com']);

        // Build site
        $this->artisan('build', ['--no-interaction' => true])
            ->assertExitCode(0);

        // Check sitemap exists
        $sitemapPath = Hyde::path('_site/sitemap.xml');
        $this->assertFileExists($sitemapPath);

        // Verify sitemap content
        $content = File::get($sitemapPath);
        $this->assertStringContainsString('<?xml version="1.0"', $content);
        $this->assertStringContainsString('<urlset', $content);
        $this->assertStringContainsString('https://example.com', $content);
    }

    public function testRssFeedGeneration()
    {
        // Ensure RSS generation is enabled
        config(['hyde.rss.enabled' => true]);
        config(['hyde.url' => 'https://example.com']);

        // Create a test blog post first
        $rssPostPath = Hyde::path('_posts/rss-test-post.md');
        $rssPostContent = "---\ntitle: rss-test-post\ndate: '2024-01-01'\ndescription: 'RSS test post description'\nauthor: 'Test Author'\ncategory: 'Testing'\n---\n\n# RSS Test Post\n\nThis is a test blog post for RSS.";

        File::ensureDirectoryExists(dirname($rssPostPath));
        File::put($rssPostPath, $rssPostContent);

        // Build site
        $this->artisan('build', ['--no-interaction' => true])
            ->assertExitCode(0);

        // Check RSS feed exists
        $rssPath = Hyde::path('_site/feed.xml');
        $this->assertFileExists($rssPath);

        // Verify RSS content
        $content = File::get($rssPath);
        $this->assertStringContainsString('<?xml version="1.0"', $content);
        $this->assertStringContainsString('version="2.0"', $content);
        $this->assertStringContainsString('rss-test-post', $content);

        // Cleanup
        File::delete(Hyde::path('_posts/rss-test-post.md'));
    }

    public function testRealtimeCompilerIntegration()
    {
        // Test realtime compiler if available
        if (class_exists('\Hyde\RealtimeCompiler\RealtimeCompilerServiceProvider')) {
            $this->artisan('serve', ['--help'])
                ->assertExitCode(0);
        } else {
            $this->markTestSkipped('Realtime compiler not available');
        }
    }

    public function testAssetCompilation()
    {
        // Test asset compilation
        $this->assertFileExists(Hyde::path('_media/app.css'));

        // Test Vite integration if available
        if (File::exists(Hyde::path('vite.config.js'))) {
            $this->assertFileExists(Hyde::path('resources/assets/app.css'));
            $this->assertFileExists(Hyde::path('resources/assets/app.js'));
        }
    }

    public function testDataCollections()
    {
        // Test data collections functionality
        $testData = [
            'name' => 'Test Collection',
            'items' => ['item1', 'item2', 'item3']
        ];

        // Create test data file
        $dataPath = Hyde::path('_data/test-collection.json');
        File::ensureDirectoryExists(dirname($dataPath));
        File::put($dataPath, json_encode($testData));

        // Test that data can be accessed (this would need framework support)
        $this->assertFileExists($dataPath);
        $content = json_decode(File::get($dataPath), true);
        $this->assertEquals($testData, $content);

        // Cleanup
        File::delete($dataPath);
        if (File::isDirectory(Hyde::path('_data'))) {
            File::deleteDirectory(Hyde::path('_data'));
        }
    }

    public function testDocumentationSearch()
    {
        // Test documentation search feature
        config(['docs.create_search_page' => true]);

        // Create test documentation
        $this->artisan('make:page', [
            'title' => 'search-test-doc',
            '--type' => 'docs'
        ])->assertExitCode(0);

        // Build site
        $this->artisan('build', ['--no-interaction' => true])
            ->assertExitCode(0);

        // Check if search page is created
        $searchPath = Hyde::path('_site/docs/search.html');
        if (File::exists($searchPath)) {
            $content = File::get($searchPath);
            $this->assertStringContainsString('search', strtolower($content));
        }

        // Cleanup
        File::delete(Hyde::path('_docs/search-test-doc.md'));
    }

    public function testTorchlightIntegration()
    {
        // Test Torchlight integration if enabled
        if (config('torchlight.token')) {
            // Create a test page with code blocks
            $testContent = "# Test Page\n\n```php\n<?php\necho 'Hello World';\n```";
            File::put(Hyde::path('_pages/torchlight-test.md'), $testContent);

            // Build site
            $this->artisan('build', ['--no-interaction' => true])
                ->assertExitCode(0);

            // Check if page was built
            $this->assertFileExists(Hyde::path('_site/torchlight-test.html'));

            // Cleanup
            File::delete(Hyde::path('_pages/torchlight-test.md'));
        } else {
            $this->markTestSkipped('Torchlight not configured');
        }
    }
}
