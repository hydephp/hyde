<?php

namespace Tests\Unit;

use App\Hyde\MarkdownPostParser;
use App\Hyde\Models\MarkdownPost;
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
		copy(realpath('./tests') . '/_stubs/_posts/test-parser-post.md', $this->getPath());
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
        return realpath('./_posts') . '/test-parser-post.md';
    }

	public function testCanParseMarkdownFile()
	{
		$post = (new MarkdownPostParser('test-parser-post'))->get();

		$this->assertInstanceOf(MarkdownPost::class, $post);
		$this->assertCount(4, ($post->matter));
		$this->assertIsString($post->body);
		$this->assertIsString($post->slug);
		$this->assertTrue(strlen($post->body) > 64);
		$this->assertTrue(strlen($post->slug) > 8);
	}
}
