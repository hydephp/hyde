<?php

/*
|--------------------------------------------------------------------------
|      __ __        __    ___  __ _____
|     / // /_ _____/ /__ / _ \/ // / _ \
|    / _  / // / _  / -_) ___/ _  / ___/
|   /_//_/\_, /\_,_/\__/_/  /_//_/_/
|        /___/
|--------------------------------------------------------------------------
|
| Welcome to HydePHP! In this file, you can customize your new Static Site!
|
| HydePHP favours convention over configuration and as such requires virtually
| no configuration out of the box to get started. Though, you may want to
| change the options to personalize your site and make it your own!
|
*/

use Hyde\Framework\Helpers\Author;
use Hyde\Framework\Helpers\Features;
use Hyde\Framework\Helpers\Meta;
use Hyde\Framework\Models\NavItem;

return [
    /*
    |--------------------------------------------------------------------------
    | Global Site Meta Tags
    |--------------------------------------------------------------------------
    |
    | While you can add any number of meta tags in the meta.blade.php component
    | using standard HTML, you can also use the Meta helper. To add a regular
    | meta tag, use Meta::name() helper. To add an Open Graph property, use
    | Meta::property() helper which also adds the `og:` prefix for you.
    |
    | Please note that some pages like blog posts contain dynamic meta tags
    | which may override these globals when present in the front matter.
    |
    */

    'meta' => [
        // Meta::name('author', 'Mr. Hyde'),
        // Meta::name('twitter:creator', '@HydeFramework'),
        // Meta::name('description', 'My Hyde Blog'),
        // Meta::name('keywords', 'Static Sites, Blogs, Documentation'),
        Meta::name('generator', 'HydePHP '.Hyde\Framework\Hyde::version()),
        Meta::property('site_name', config('site.name', 'HydePHP')),
    ],

    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | Some of Hyde's features are optional. Feel free to disable the features
    | you don't need by removing or commenting them out from this array.
    | This config concept is directly inspired by Laravel Jetstream.
    |
    */

    'features' => [
        // Page Modules
        Features::blogPosts(),
        Features::bladePages(),
        Features::markdownPages(),
        Features::documentationPages(),
        // Features::dataCollections(),

        // Frontend Features
        Features::darkmode(),
        Features::documentationSearch(),

        // Integrations
        Features::torchlight(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Blog Post Authors
    |--------------------------------------------------------------------------
    |
    | Hyde has support for adding authors in front matter, for example to
    | automatically add a link to your website or social media profiles.
    | However, it's tedious to have to add those to each and every
    | post you make, and keeping them updated is even harder.
    |
    | Here you can add predefined authors. When writing posts,
    | just specify the username in the front matter, and the
    | rest of the data will be pulled from a matching entry.
    |
    */

    'authors' => [
        Author::create(
            username: 'mr_hyde', // Required username
            name: 'Mr. Hyde', // Optional display name
            website: 'https://hydephp.com' // Optional website URL
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Footer Text
    |--------------------------------------------------------------------------
    |
    | Most websites have a footer with copyright details and contact information.
    | You probably want to change the Markdown to include your information,
    | though you are of course welcome to keep the attribution link!
    |
    | You can also customize the blade view if you want a more complex footer.
    | You can disable it completely by setting `enabled` to `false`.
    |
    */

    'footer' => [
        'enabled' => true,
        'markdown' => 'Site proudly built with [HydePHP](https://github.com/hydephp/hyde) 🎩',
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation Menu Configuration
    |--------------------------------------------------------------------------
    |
    | If you are looking to customize the navigation menu links, this is the place!
    |
    | See the documentation for the full list of options:
    | https://hydephp.com/docs/master/customization#navigation-menu--sidebar
    |
    */

    'navigation' => [
        // This configuration sets the priorities used to determine the order of the menu.
        // The default values have been added below for reference and easy editing.
        'order' => [
            'index' => 0,
            'posts' => 10,
            'docs' => 100,
        ],

        // These are the pages that should not show up in the navigation menu.
        'exclude' => [
            '404',
        ],

        // Any extra links you want to add to the navigation menu can be added here.
        // To get started quickly, you can uncomment the defaults here.
        // See the documentation link above for more information.
        'custom' => [
            // NavItem::toLink('https://github.com/hydephp/hyde', 'GitHub', 200),
        ],
    ],
];
