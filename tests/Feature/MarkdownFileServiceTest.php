<?php

namespace Tests\Feature;

use Hyde\Framework\Hyde;
use Hyde\Framework\Models\MarkdownDocument;
use Hyde\Framework\Services\MarkdownFileService;
use Tests\TestCase;

class MarkdownFileServiceTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        createTestPost();
    }

    protected function tearDown(): void
    {
        unlink(Hyde::path('_posts/test-post.md'));

        parent::tearDown();
    }

    public function test_can_parse_markdown_file()
    {
        $document = (new MarkdownFileService(Hyde::path('_posts/test-post.md')))->get();
        $this->assertInstanceOf(MarkdownDocument::class, $document);

        $this->assertEquals([
            'title' => 'My New Post',
            'category' => 'blog',
            'author' => 'Mr. Hyde',
        ], $document->matter);

        $this->assertEquals(
            '# My New PostThis is a post stub used in the automated tests',
            str_replace(["\n", "\r"], '', $document->body)
        );
    }

    public function test_parsed_markdown_post_contains_valid_front_matter()
    {
        $post = (new MarkdownFileService(Hyde::path('_posts/test-post.md')))->get();
        $this->assertEquals('My New Post', $post->matter['title']);
        $this->assertEquals('Mr. Hyde', $post->matter['author']);
        $this->assertEquals('blog', $post->matter['category']);
    }
}
