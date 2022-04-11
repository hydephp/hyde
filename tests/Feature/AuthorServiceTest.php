<?php

namespace Tests\Feature;

use Hyde\Framework\Models\Author;
use Hyde\Framework\Services\AuthorService;
use Illuminate\Support\Collection;
use Tests\TestCase;

class AuthorServiceTest extends TestCase
{
    public function test_setup()
    {
        // If an authors.yml file exists, back it up and remove it
        $service = new AuthorService();
        $path = $service->filepath;

        backup($path);
        unlinkIfExists($path);

        $this->assertTrue(true);
    }

    public function test_publish_file_creates_file()
    {
        $service = new AuthorService();
        $path = $service->filepath;

        if (file_exists($path)) {
            unlink($path);
        }

        $service->publishFile();
        $this->assertFileExists($path);
    }

    public function test_get_authors_returns_author_collection()
    {
        $service = new AuthorService();
        $service->publishFile();

        $collection = $service->authors;

        $this->assertInstanceOf(Collection::class, $collection);

        $author = $collection->first();

        $this->assertInstanceOf(Author::class, $author);

        $this->assertEquals('mr_hyde', $author->username);
        $this->assertEquals('Mr Hyde', $author->name);
        $this->assertEquals('https://github.com/hydephp/hyde', $author->website);
    }

    public function test_can_find_author_by_username()
    {
        $service = new AuthorService();
        $service->publishFile();

        $author = AuthorService::find('mr_hyde');

        $this->assertInstanceOf(Author::class, $author);

        $this->assertEquals('mr_hyde', $author->username);
        $this->assertEquals('Mr Hyde', $author->name);
        $this->assertEquals('https://github.com/hydephp/hyde', $author->website);
    }

    public function test_get_yaml_can_parse_file()
    {
        $service = new AuthorService();

        $service->publishFile();

        $array = $service->getYaml();

        $this->assertIsArray($array);

        $this->assertEquals([
            'authors' => [
                'mr_hyde' =>  [
                    'name' => 'Mr Hyde',
                    'website' => 'https://github.com/hydephp/hyde',
                ],
            ],
        ], $array);
    }

    public function test_teardown()
    {
        // Clean up any test files
        $service = new AuthorService();
        $path = $service->filepath;
        unlinkIfExists($path);

        // Restore the original authors.yml file

        restore($path);

        $this->assertTrue(true);
    }
}
