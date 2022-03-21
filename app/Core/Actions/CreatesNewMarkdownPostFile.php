<?php

namespace App\Core\Actions;

use App\Core\Hyde;
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
    public function __construct(
        string $title,
        ?string $description,
        ?string $category,
        ?string $author,
        ?string $date = null,
        ?string $slug = null
    ) {
        $this->title = $title ?? 'My Awesome Blog Post';
        $this->description = $description ?? 'A short description used in previews and SEO';
        $this->category = $category ?? 'blog';
        $this->author = $author ?? 'Mr. Hyde';
        if ($date === null) {
            $this->date = date('Y-m-d H:i');
        }
        if ($slug === null) {
            $this->slug = Str::slug($title) ;
        }
    }

    /**
     * Save the class object to a Markdown file.
     *
     * @param bool $force Should the file be created even if a file with the same path already exists?
     * @return string|false Returns the path to the file if successful, or false if the file could not be saved.
     * @throws Exception if a file with the same slug already exists and the force flag is not set.
     */
    public function save(bool $force = false): string|false
    {

        $path = Hyde::path("_posts/$this->slug.md");

        if ($force !== true && file_exists($path)) {
            throw new Exception("File at $path already exists! ", 409);
        }

        $arrayWithoutSlug = ((array) $this);

        unset($arrayWithoutSlug['slug']);

        $contents = (new ConvertsArrayToFrontMatter)->execute($arrayWithoutSlug) .
            "\n## Write something awesome.\n\n";

        return file_put_contents($path, $contents) ? $path : false;
    }
}
