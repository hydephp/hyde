<?php

namespace App\Core\Actions;

use App\Core\Models\DocumentationPage;
use App\Core\Services\CollectionService;
use Illuminate\Support\Str;
use function config;

/**
 * Create the sidebar items for the documentation page.
 */
class GeneratesDocumentationSidebar
{
    /**
     * Create and get the array.
     *
     * @param string $current
     * @return array
     */
    public static function get(string $current = ""): array
    {
        $orderArray = config('hyde.documentationPageOrder');

        foreach ($orderArray as $key => $value) {
            $orderArray[$key] = Str::slug($value);
        }

        $array = [];

        foreach (CollectionService::getSourceSlugsOfModels(DocumentationPage::class) as $slug) {
            if ($slug == 'index') {
                continue;
            }

            $order = array_search($slug, $orderArray);

            if ($order === false) {
                $order = 999;
            }

            $array[] = [
                'slug' => $slug,
                'title' => Str::title(str_replace('-', ' ', $slug)),
                'active' => 'docs/' . $slug == $current,
                'order' =>  $order,
            ];
        }

        krsort($array);

        usort($array, function ($a, $b) {
            return $a['order'] <=> $b['order'];
        });

        return $array;
    }
}
