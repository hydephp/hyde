<?php

namespace App\Actions;

use App\Hyde\Models\DocumentationPage;
use App\Hyde\Services\CollectionService;
use Illuminate\Support\Str;

/**
 * Create the sidebar items for the documentation page.
 */
class GeneratesDocumentationSidebar
{
    /**
     * Create and get the array.
     * 
     * @todo read metadata from the markdown files to determine the order.
     * 
     * @param string $current
     * @return array
     */
    public static function get(string $current = ""): array
    {
        $array = [];

        foreach (CollectionService::getSourceSlugsOfModels(DocumentationPage::class) as $slug) {
            $array[] = [
                'slug' => $slug,
                'title' => Str::title(str_replace('-', ' ', $slug)),
                'active' => 'docs/' . $slug == $current,
            ];
        }

        return $array;
    }
}
