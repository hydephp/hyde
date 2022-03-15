<?php

namespace App\Actions;

use Exception;
use Illuminate\Support\Str;

class CreatesNewMarkdownPostFile
{
    public string $title;
    public string $description;
    public string $category;
    public string $author;
    public string $date;
    public string $slug;

    /**
     * Construct the class.
     *
     * @param string $title
     * @param string|null $description
     * @param string|null $category
     * @param string|null $author
     * @param string|null $date
     * @param string|null $slug
     */
    public function __construct( string $title,
                                ?string $description,
                                ?string $category,
                                ?string $author,
                                ?string $date = null,
                                ?string $slug = null)
    {
        $this->title = $title ?? 'My Awesome Blog Post';
        $this->description = $description ?? 'A short description used in previews and SEO';
        $this->category = $category ?? 'blog';
        $this->author = $author ?? 'Mr. Hyde';
        if ($date === null) $this->date = date('Y-m-d H:i');
        if ($slug === null) $this->slug = Str::slug($title) ;
    }

    /**
     * Save the class object to a Markdown file.
     * 
     * @todo Remove the slug key from the generated front matter as it is not parsed
     *
     * @param bool $force Should the file be created even if a file with the same path already exists?
     * @return string|false Returns the path to the file if successful, or false if the file could not be saved.
     * @throws Exception if a file with the same slug already exists and the force flag is not set.
     */
    public function save(bool $force = false): string|false
    {
        $path = realpath('./_posts') . DIRECTORY_SEPARATOR . "$this->slug.md";

        if ($force !== true && file_exists($path)) {
            throw new Exception("File at $path already exists! ", 409);
        }

        $contents = (new ConvertsArrayToFrontMatter)->execute((array) $this) . "\n# $this->title\n\n";

        return file_put_contents($path, $contents) ? $path : false;
    }
}