<?php

namespace App\Core\Models;

use App\Core\Hyde;
use App\Core\MarkdownPostParser;
use Illuminate\Support\Collection;

/**
 * A simple class that contains the Front Matter and Markdown text of a post.
 */
class MarkdownPost
{
    /**
     * The Front Matter
     * @var array
     */
    public array $matter;

    /**
     * The Markdown body
     * @var string
     */
    public string $body;

    /**
     * The Post slug
     * @var string
     */
    public string $slug;

    /**
     * Construct the object.
     *
     * @param array $matter
     * @param string $body
     * @param string $slug
     */
    public function __construct(array $matter, string $body, string $slug)
    {
        $this->matter = $matter;
        $this->body = $body;
        $this->slug = $slug;
    }

    /**
     * Get a Laravel Collection of all Posts as MarkdownPost objects.
     * @return Collection
     */
    public static function getCollection(): Collection
    {
        $collection = new Collection();

        foreach (glob(Hyde::path('_posts/*.md')) as $filepath) {
            $collection->push((new MarkdownPostParser(basename($filepath, '.md')))->get());
        }

        return $collection->sortByDesc('matter.date');
    }
}
