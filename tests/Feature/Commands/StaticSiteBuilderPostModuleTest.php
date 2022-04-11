<?php

namespace Tests\Feature\Commands;

use Hyde\Framework\Hyde;
use Hyde\Framework\Models\MarkdownPost;
use Hyde\Framework\StaticPageBuilder;
use Tests\TestCase;

/**
 * Test the post compiler module.
 *
 * @see Tests\Unit\MarkdownPostParserTest for the Markdown parser test.
 */
class StaticSiteBuilderPostModuleTest extends TestCase
{
    protected MarkdownPost $post;

    protected function setUp(): void
    {
        parent::setUp();

        $this->post = new MarkdownPost([
            'title' => 'Adventures in Wonderland',
            'description' => 'All in the golden afternoon, full leisurely we glide.',
            'category' => 'novels',
            'author' => 'Lewis Carroll',
            'date' => '1865-11-18 18:52',
        ], "## CHAPTER I. DOWN THE RABBIT-HOLE. \n\nSo she was considering in her own mind, as well as she could, for the hot day made her feel very sleepy and stupid.", 'Test Title', 'test-post');

        // Make sure no file exists which could cause unintended results.
        unlinkIfExists(Hyde::path('_site/posts/test-post.html'));
    }

    protected function tearDown(): void
    {
        unlink(Hyde::path('_site/posts/test-post.html'));

        parent::tearDown();
    }

    protected function inspectHtml(array $expectedStrings)
    {
        new StaticPageBuilder($this->post, true);
        $stream = file_get_contents(Hyde::path('_site/posts/test-post.html'));

        foreach ($expectedStrings as $expectedString) {
            $this->assertStringContainsString($expectedString, $stream);
        }
    }

    public function test_can_create_post()
    {
        $builder = new StaticPageBuilder($this->post);

        $builder->__invoke();

        $this->assertFileExists(Hyde::path('_site/posts/test-post.html'));
    }

    public function test_post_contains_expected_content()
    {
        $this->inspectHtml([
            'Adventures in Wonderland',
            'Saturday Nov 18th, 1865, at 6:52pm',
            'Lewis Carroll',
            'in the category "novels"',
            '<h2>CHAPTER I. DOWN THE RABBIT-HOLE.</h2>',
            '<p>So she was considering in her own mind, as well as she could',
        ]);
    }

    public function test_post_contains_expected_elements()
    {
        $this->inspectHtml([
            '<!DOCTYPE html>',
            '<html',
            '<head',
            '<body',
            '<main',
            '<article',
            '<meta',
            '<header',
            '<h1',
            '<time',
            '<address',
        ]);
    }

    public function test_post_contains_expected_meta_tags()
    {
        $this->inspectHtml([
            '<meta name="description" content="All in the golden afternoon, full leisurely we glide.">',
            '<meta name="author" content="Lewis Carroll">',
            '<meta name="keywords" content="novels">',
            '<meta property="og:type" content="article">',
            '<meta property="og:title" content="Adventures in Wonderland">',
            '<meta property="og:article:published_time" content="1865-11-18T18:52:00+00:00">',
        ]);
    }

    public function test_post_contains_expected_itemprops()
    {
        $this->inspectHtml([
            'itemtype="https://schema.org/Article"',
            'itemtype="https://schema.org/Person"',
            'itemprop="identifier"',
            'itemprop="headline"',
            'itemprop="dateCreated datePublished"',
            'itemprop="author"',
            'itemprop="name"',
            'itemprop="articleBody"',
        ]);
    }

    public function test_post_contains_expected_aria_support()
    {
        $this->inspectHtml([
            'role="doc-pageheader"',
            'role="doc-introduction"',
            'aria-label="About the post"',
        ]);
    }
}
