<?php

namespace App\Hyde\Models;

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
}
