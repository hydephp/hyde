<?php

namespace Tests\Unit;

use Hyde\Framework\Hyde;
use Hyde\Framework\MarkdownPostParser;
use Hyde\Framework\Models\MarkdownPost;
use Tests\TestCase;

/**
 * @see Tests\Feature\Commands\StaticSiteBuilderPostModuleTest for the compiler test.
 */
class MarkdownPostParserTest extends TestCase
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
        $post = (new MarkdownPostParser('test-post'))->get();
        $this->assertInstanceOf(MarkdownPost::class, $post);
        $this->assertCount(4, ($post->matter));
        $this->assertIsArray($post->matter);
        $this->assertIsString($post->body);
        $this->assertIsString($post->slug);
        $this->assertTrue(strlen($post->body) > 32);
        $this->assertTrue(strlen($post->slug) > 8);
    }

    public function test_parsed_markdown_post_contains_valid_front_matter()
    {
        $post = (new MarkdownPostParser('test-post'))->get();
        $this->assertEquals('My New Post', $post->matter['title']);
        $this->assertEquals('Mr. Hyde', $post->matter['author']);
        $this->assertEquals('blog', $post->matter['category']);
        $this->assertEquals('test-post', $post->matter['slug']);
    }
}
