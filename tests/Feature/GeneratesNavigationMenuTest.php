<?php

namespace Tests\Feature;

use Hyde\Framework\Actions\GeneratesNavigationMenu;
use Hyde\Framework\Hyde;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class GeneratesNavigationMenuTest extends TestCase
{
    public function test_get_method_returns_array()
    {
        $array = GeneratesNavigationMenu::getNavigationLinks();
        $this->assertIsArray($array);
    }

    public function test_generated_links_include_documentation_pages()
    {
        touch(Hyde::path('_docs/index.md'));

        $generator = new GeneratesNavigationMenu('index');
        $this->assertIsArray($generator->links);

        $this->assertContains('docs/index.html', Arr::flatten($generator->links));
    }

    public function test_get_links_from_config_method()
    {
        $generator = new GeneratesNavigationMenu(currentPage: 'foo/bar');

        Config::set('hyde.navigationMenuLinks', [
            [
                'title' => 'GNMTestExt',
                'destination' => 'https://example.org/test',
                'priority' => 800,
            ],
            [
                'title' => 'GNMTestInt',
                'slug' => 'foo/bar',
            ],
        ]);

        $result = $generator->getLinksFromConfig();

        $this->assertCount(2, $result);

        $this->assertEquals($result[0], [
            'title' => 'GNMTestExt',
            'route' => 'https://example.org/test',
            'current' => false,
            'priority' => 800,
        ]);

        $this->assertEquals([
            'title' => 'GNMTestInt',
            'route' => '../foo/bar.html',
            'current' => true,
            'priority' => 999,
        ], $result[1]);
    }
}
