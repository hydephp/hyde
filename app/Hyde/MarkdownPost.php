<?php

namespace App\Hyde;

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
     * Construct the object.
     *
     * @param array $matter
     * @param string $body
     */
    public function __construct(array $matter, string $body)
    {
        $this->matter = $matter;
        $this->body = $body;
    }
}
