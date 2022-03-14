<?php

namespace Tests\Unit;

use App\Hyde\MarkdownPost;
use App\Hyde\MarkdownPostParser;
use PHPUnit\Framework\TestCase;

class MarkdownPostParserTest extends TestCase
{
	/**
	 * Create a Markdown file to work with
	 */
	public function createWorkingFile()
	{

		file_put_contents($this->getPath(), <<<'EOF'
---
title: My New Post
category: blog
author: Mr. Hyde
---

# My New Post

I'm baby affogato iPhone narwhal selvage pitchfork forage.
EOF
);
	}

	/**
     * Get the path of the test Markdown file.
     *
     * @return string
     */
    public function getPath(): string
    {
        return realpath('./_posts') . '/test-parser.md';
    }

    /**
     * Clean up after tests by removing the created file.
     *
     * @return void
     */
    public function cleanUp(): void
    {
        unlink($this->getPath());
    }

	public $post;

	public function testCanParseMarkdownFile()
	{
		$this->createWorkingFile();
		
		$post = (new MarkdownPostParser('test-parser'))->get();
		$this->assertInstanceOf(MarkdownPost::class, $post);
		$this->assertCount(4, ($post->matter));
		$this->assertIsString($post->body);
		$this->assertIsString($post->slug);
		$this->assertTrue(strlen($post->body) > 64);
		$this->assertTrue(strlen($post->slug) > 8);
		$this->cleanUp();
	}
}
