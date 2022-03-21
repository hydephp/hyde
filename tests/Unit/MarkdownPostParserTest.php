<?php

namespace Tests\Unit;

use Hyde\Framework\Hyde;
use Hyde\Framework\MarkdownPostParser;
use Hyde\Framework\Models\MarkdownPost;
use PHPUnit\Framework\TestCase;

class MarkdownPostParserTest extends TestCase
{
    /**
     * Setup the test environment.
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();

		// Create a Markdown file to work with
		copy(Hyde::path('tests/_stubs/_posts/test-parser-post.md'), $this->getPath());
	}

    /**
     * Clean up the testing environment before the next test.
     * @return void
     */
    protected function tearDown(): void
    {
		// Remove the published stub file
        unlink($this->getPath());

        parent::tearDown();
    }

	/**
     * Get the path of the test Markdown file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return Hyde::path('_posts/test-parser-post.md');
    }

	public function testCanParseMarkdownFile()
	{
		$post = (new MarkdownPostParser('test-parser-post'))->get();
		$this->assertInstanceOf(MarkdownPost::class, $post);
		$this->assertCount(4, ($post->matter));
		$this->assertIsArray($post->matter);
		$this->assertIsString($post->body);
		$this->assertIsString($post->slug);
		$this->assertTrue(strlen($post->body) > 32);
		$this->assertTrue(strlen($post->slug) > 8);
	}

	public function testParsedMarkdownPostContainsValidFrontMatter()
	{
		$post = (new MarkdownPostParser('test-parser-post'))->get();
        $this->assertEquals('My New Post', $post->matter['title']);
        $this->assertEquals('Mr. Hyde', $post->matter['author']);
        $this->assertEquals('blog', $post->matter['category']);
        $this->assertEquals('test-parser-post', $post->matter['slug']);
	}
}
