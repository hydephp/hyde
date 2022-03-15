<?php

namespace App\Hyde\Actions;

/**
 * Creates and returns a list of markdown paths
 * @deprecated as it will be moved into a static method in the post class
 */
class GetMarkdownPostList
{
    /**
     * @return array
     */
    public function execute(): array
    {
        $array = [];

        foreach (glob(base_path('_posts/*.md')) as $filepath) {
            $array[basename($filepath, '.md')] = $filepath;
        }

        return $array;
    }
}
