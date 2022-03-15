<?php

namespace App\Actions;

use App\Hyde\Models\MarkdownPage;

/**
 * Generate the dynamic navigation menu.
 */
class GeneratesNavigationMenu
{
    /**
     * The current page route string
     *
     * Used to check if a given link is active,
     * and more importantly it is needed to
     * assemble the relative link paths.
     *
     * @example 'posts/my-new-post.html'
     * @example 'index.html'
     *
     * @var string
     */
    public string $currentPage;

    /**
     * The created array of navigation links
     * @var array
     */
    public array $links;

    /**
     * Construct the class
     * @param string $currentPage
     */
    public function __construct(string $currentPage)
    {
        $this->currentPage = $currentPage;

        $this->links = $this->getLinks();
    }

    /**
     * Create the link array
     * @return array
     */
    private function getLinks(): array
    {
        $links = [];

        foreach ($this->getListOfCustomPages() as $slug) {
            $links[] = [
                'title' => $slug, // Todo get the proper title from slug
                'route' => $this->getRelativeRoutePathForSlug($slug),
                'current' => $this->currentPage == $slug,
            ];
        }

        return $links;
    }

    /**
     * Get a list of all the top level pages
     * @return array
     */
    private function getListOfCustomPages(): array
    {
        $array = [];

        foreach (glob(base_path('resources/views/pages/*.blade.php')) as $path) {
            $array[] = basename($path, '.blade.php');
        }

        return array_unique(array_merge($array, array_keys(MarkdownPage::allAsArray())));
    }

    /**
     * Inject the proper number of `../` before the links
     * @param string $slug
     * @return string
     */
    private function getRelativeRoutePathForSlug(string $slug): string
    {
        $nestCount = substr_count($this->currentPage, '/');
        $route = "";
        if ($nestCount > 0) {
           $route .= str_repeat('../', $nestCount);
        }
        $route .= $slug . '.html';
        return $route;
    }

    /**
     * Static helper to get the array of navigation links
     * @param string $currentPage
     * @return array
     */
    public static function getNavigationLinks(string $currentPage = 'index'): array
    {
        $generator = new self($currentPage);
        return $generator->links;
    }
}
