<?php

namespace Tests\Feature;

use Hyde\Framework\Actions\CreatesNewMarkdownPostFile;
use Hyde\Framework\Hyde;
use Tests\TestCase;

/**
 * Test that the config/authors.yml feature works in
 * conjunction with the static Post generator.
 *
 * @see AuthorServiceTest
 * @see StaticSiteBuilderPostModuleTest
 */
class AuthorPostsIntegrationTest extends TestCase
{
    /**
     * Set up the test environment.
     *
     * @return void
     */
    public function test_setup_integration_test_environment()
    {
        // If an authors.yml file exists, back it up.
        if (file_exists(Hyde::path('config/authors.yml')) && ! file_exists(Hyde::path('config/authors.yml.bak'))) {
            copy(Hyde::path('config/authors.yml'), Hyde::path('config/authors.yml.bak'));
        }

        // Create a new authors.yml file.
        file_put_contents(Hyde::path('config/authors.yml'), "authors:\n");

        $this->assertTrue(true);
    }

    /**
     * Baseline test to create a post without a defined author,
     * and assert that the username is displayed as is.
     *
     * Check that the author was not defined.
     * We do this by building the static site and inspecting the DOM.
     */
    public function test_create_post_with_undefined_author()
    {
        // Create a new post
        (new CreatesNewMarkdownPostFile(
            title: 'test-2dcbb2c-post-with-undefined-author',
            description: '',
            category: '',
            author: 'test_undefined_author'
        ))->save(true);

        // Check that the post was created
        $this->assertFileExists(Hyde::path('_posts/test-2dcbb2c-post-with-undefined-author.md'));

        // Build the static page
        $this->artisan('rebuild _posts/test-2dcbb2c-post-with-undefined-author.md')->assertExitCode(0);

        // Check that the file was created
        $this->assertFileExists(Hyde::path('_site/posts/test-2dcbb2c-post-with-undefined-author.html'));

        // Check that the author is rendered as is in the DOM
        $this->assertStringContainsString(
            '>test_undefined_author</span>',
            file_get_contents(Hyde::path('_site/posts/test-2dcbb2c-post-with-undefined-author.html'))
        );

        // Remove the test files
        unlink(Hyde::path('_posts/test-2dcbb2c-post-with-undefined-author.md'));
        unlink(Hyde::path('_site/posts/test-2dcbb2c-post-with-undefined-author.html'));
    }

    /**
     * Test that a defined author has its name injected into the DOM.
     */
    public function test_create_post_with_defined_author_with_name()
    {
        // Create a new post
        (new CreatesNewMarkdownPostFile(
            title: 'test-2dcbb2c-post-with-defined-author-with-name',
            description: '',
            category: '',
            author: 'test_named_author'
        ))->save(true);

        // Check that the post was created
        $this->assertFileExists(Hyde::path('_posts/test-2dcbb2c-post-with-defined-author-with-name.md'));

        // Add the author to the authors.yml file
        file_put_contents(
            Hyde::path('config/authors.yml'),
            'authors:
  test_named_author:
    name: Test Author'
        );

        // Check that the post was created
        $this->assertFileExists(Hyde::path('_posts/test-2dcbb2c-post-with-defined-author-with-name.md'));
        // Build the static page
        $this->artisan('rebuild _posts/test-2dcbb2c-post-with-defined-author-with-name.md')->assertExitCode(0);
        // Check that the file was created
        $this->assertFileExists(Hyde::path('_site/posts/test-2dcbb2c-post-with-defined-author-with-name.html'));

        // Check that the author is contains the set name in the DOM
        $this->assertStringContainsString(
            '<span itemprop="name" aria-label="The author\'s name" title=@test_named_author>Test Author</span>',
            file_get_contents(Hyde::path('_site/posts/test-2dcbb2c-post-with-defined-author-with-name.html'))
        );

        // Remove the test files
        unlink(Hyde::path('_posts/test-2dcbb2c-post-with-defined-author-with-name.md'));
        unlink(Hyde::path('_site/posts/test-2dcbb2c-post-with-defined-author-with-name.html'));
    }

    /**
     * Test that a defined author with website has its site linked.
     */
    public function test_create_post_with_defined_author_with_website()
    {
        // Create a new post
        (new CreatesNewMarkdownPostFile(
            title: 'test-2dcbb2c-post-with-defined-author-with-name',
            description: '',
            category: '',
            author: 'test_author_with_website'
        ))->save(true);

        // Check that the post was created
        $this->assertFileExists(Hyde::path('_posts/test-2dcbb2c-post-with-defined-author-with-name.md'));

        // Add the author to the authors.yml file
        file_put_contents(
            Hyde::path('config/authors.yml'),
            'authors:
  test_author_with_website:
    name: Test Author
    website: https://example.org
'
        );

        // Check that the post was created
        $this->assertFileExists(Hyde::path('_posts/test-2dcbb2c-post-with-defined-author-with-name.md'));
        // Build the static page
        $this->artisan('rebuild _posts/test-2dcbb2c-post-with-defined-author-with-name.md')->assertExitCode(0);
        // Check that the file was created
        $this->assertFileExists(Hyde::path('_site/posts/test-2dcbb2c-post-with-defined-author-with-name.html'));

        // Check that the author is contains the set name in the DOM
        $this->assertStringContainsString(
            '<span itemprop="name" aria-label="The author\'s name" title=@test_author_with_website>Test Author</span>',
            file_get_contents(Hyde::path('_site/posts/test-2dcbb2c-post-with-defined-author-with-name.html'))
        );

        // Check that the author is contains the set website in the DOM
        $this->assertStringContainsString(
            '<a href="https://example.org" rel="author" itemprop="url" aria-label="The author\'s website">',
            file_get_contents(Hyde::path('_site/posts/test-2dcbb2c-post-with-defined-author-with-name.html'))
        );

        // Remove the test files
        unlink(Hyde::path('_posts/test-2dcbb2c-post-with-defined-author-with-name.md'));
        unlink(Hyde::path('_site/posts/test-2dcbb2c-post-with-defined-author-with-name.html'));
    }

    /**
     * Tear down the test environment.
     *
     * @return void
     */
    public function test_teardown_integration_test_environment()
    {
        // Remove the test authors.yml file.
        unlink(Hyde::path('config/authors.yml'));

        // If an authors.yml backup exists, restore it.
        if (file_exists(Hyde::path('config/authors.yml.bak'))) {
            copy(Hyde::path('config/authors.yml.bak'), Hyde::path('config/authors.yml'));
            unlink(Hyde::path('config/authors.yml.bak'));
        }

        $this->assertTrue(true);
    }
}
