<?php

namespace App\Hyde\Services;

use App\Hyde\Models\BladePage;
use App\Hyde\Models\MarkdownPage;
use App\Hyde\Models\MarkdownPost;
use App\Hyde\Models\DocumentationPage;

/**
 * Contains service methods to return helpful collections of arrays and lists.
 */
class CollectionService
{
    /**
     * Return an array of all the source markdown slugs of the specified model.
     * Array format is ['_relative/path.md' => 'path.md']
     * @param string $model
     * @return array|false array on success, false if the class was not found
     */
    public static function getSourceSlugsOfModels(string $model): array|false
    {
        if ($model == BladePage::class) {
            return self::getBladePageList();
        }

        if ($model == MarkdownPage::class) {
            return self::getMarkdownPageList();
        }

        if ($model == MarkdownPost::class) {
            return self::getMarkdownPostList();
        }

        if ($model == DocumentationPage::class) {
            return self::getDocumentationPageList();
        }

        return false;
    }

    /**
     * Get all the Blade files in the resources/views/pages directory.
     * @return array
     */
    public static function getBladePageList(): array
    {
        $array = [];

        foreach (glob(base_path('resources/views/pages/*.blade.php')) as $filepath) {
            $array[] = basename($filepath, '.blade.php');
        }

        return $array;
    }

    /**
     * Get all the Markdown files in the _pages directory.
     * @return array
     */
    public static function getMarkdownPageList(): array
    {
        $array = [];

        foreach (glob(base_path('_pages/*.md')) as $filepath) {
            $array[] = basename($filepath, '.md');
        }

        return $array;
    }

    /**
     * Get all the Markdown files in the _posts directory.
     * @return array
     */
    public static function getMarkdownPostList(): array
    {
        $array = [];

        foreach (glob(base_path('_posts/*.md')) as $filepath) {
            $array[] = basename($filepath, '.md');
        }

        return $array;
    }


    /**
     * Get all the Markdown files in the _docs directory.
     * @return array
     */
    public static function getDocumentationPageList(): array
    {
        $array = [];

        foreach (glob(base_path('_docs/*.md')) as $filepath) {
            $array[] = basename($filepath, '.md');
        }

        return $array;
    }

}
