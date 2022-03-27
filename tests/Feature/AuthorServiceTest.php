<?php

namespace Tests\Feature;

use Hyde\Framework\Models\Author;
use Hyde\Framework\Services\AuthorService;
use Illuminate\Support\Collection;
use PHPUnit\Framework\TestCase;

class AuthorServiceTest extends TestCase
{
    public function testPublishFileCreatesFile()
    {
        $service = new AuthorService();
        $path = $service->filepath;

        if (file_exists($path)) {
            unlink($path);
        }

        $service->publishFile();
        $this->assertFileExists($path);
    }

    public function testGetAuthorsReturnsAuthorCollection()
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

    public function testCanFindAuthorByUsername()
    {
        $service = new AuthorService();
        $service->publishFile();

        $author = AuthorService::find('mr_hyde');

        $this->assertInstanceOf(Author::class, $author);

        $this->assertEquals('mr_hyde', $author->username);
        $this->assertEquals('Mr Hyde', $author->name);
        $this->assertEquals('https://github.com/hydephp/hyde', $author->website);
    }

    public function testGetYamlCanParseFile()
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
}
