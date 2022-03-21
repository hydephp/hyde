<?php

namespace App\Core\Actions;

use App\Core\Features;
use App\Core\Hyde;
use App\Core\Models\MarkdownPage;
use Illuminate\Support\Str;
use function config;

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
     *
     * @todo Cache the base array and only update the 'current' attribute on each request.
     *
     * @return array
     */
    private function getLinks(): array
    {
        $links = $this->getLinksFromConfig();

        // Automatically add top level pages
        foreach ($this->getListOfCustomPages() as $slug) {
            $title = $this->getTitleFromSlug($slug);
            // Only add the automatic link if it is not present in the config array
            if (!in_array($title, array_column($links, 'title'))) {
                $links[] = [
                    'title' => $title,
                    'route' => $this->getRelativeRoutePathForSlug($slug),
                    'current' => $this->currentPage == $slug,
                    'priority' => $slug == "index" ? 100 : 999,
                ];
            }
        }

        // Add extra links

        // If the documentation feature is enabled...
        if (Features::hasDocumentationPages()) {
            // And there is no link to the docs...
            if (!in_array('Docs', array_column($links, 'title'))) {
                // But a suitable file exists...
                if (file_exists('_docs/index.md') || file_exists('_docs/readme.md')) {
                    // Then we can add a link.
                    $links[] = [
                        'title' => 'Docs',
                        'route' => $this->getRelativeRoutePathForSlug(
                            file_exists('_docs/index.md') ? 'docs/index' : 'docs/readme'
                        ),
                        'current' => false,
                        'priority' => 500,
                    ];
                }
            }
        }

        // Remove config defined blacklisted links
        foreach ($links as $key => $link) {
            if (in_array(Str::slug($link['title']), config('hyde.navigationMenuBlacklist', []))) {
                unset($links[$key]);
            }
        }

        // Sort

        $columns = array_column($links, 'priority');
        array_multisort($columns, SORT_ASC, $links);

        return $links;
    }

    /**
     * Get the custom navigation links from the config, if there are any
     * @return array
     */
    private function getLinksFromConfig(): array
    {
        $configLinks = config('hyde.navigationMenuLinks', []);

        $links = [];

        if (sizeof($configLinks) > 0) {
            foreach ($configLinks as $link) {
                $links[] = [
                    'title' => $link['title'],
                    'route' => $link['destination'] ?? $this->getRelativeRoutePathForSlug($link['slug']),
                    'current' => isset($link['slug']) ? $this->currentPage == $link['slug'] : false,
                    'priority' =>  $link['priority'] ?? 999,
                ];
            }
        }

        return $links;
    }

    /**
     * Get the page title
     *
     * @todo fetch this from the front matter
     *
     * @param string $slug
     * @return string
     */
    public function getTitleFromSlug(string $slug): string
    {
        if ($slug == "index") {
            return "Home";
        }
        return Str::title(str_replace('-', ' ', $slug));
    }

    /**
     * Get a list of all the top level pages
     * @return array
     */
    private function getListOfCustomPages(): array
    {
        $array = [];

        foreach (glob(Hyde::path('resources/views/pages/*.blade.php')) as $path) {
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
