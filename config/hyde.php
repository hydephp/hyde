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
| Tip: The settings here can also be overridden by creating a hyde.yml file
| in the root of your project directory. Note that these cannot call any
| PHP functions, so you can't use env() or similar helpers. Also, note
| that any settings in the yml file will override settings here.
|
*/

use Hyde\Facades\Author;
use Hyde\Facades\Features;
use Hyde\Facades\Meta;

return [

    /*
    |--------------------------------------------------------------------------
    | Site Name
    |--------------------------------------------------------------------------
    |
    | This value sets the name of your site and is, for example, used in
    | the compiled page titles and more. The default value is HydePHP.
    |
    */

    'name' => env('SITE_NAME', 'HydePHP'),

    /*
    |--------------------------------------------------------------------------
    | Site Base URL
    |--------------------------------------------------------------------------
    |
    | Setting a base URL is highly recommended, and is required to use some
    | HydePHP features, like automatic sitemaps and RSS feeds.
    |
    | If you are serving your site from a subdirectory,
    | you will need to include that in the path.
    |
    */

    'url' => env('SITE_URL', 'http://localhost'),

    /*
    |--------------------------------------------------------------------------
    | Pretty URLs
    |--------------------------------------------------------------------------
    |
    | When the setting is enabled, generated links in the compiled HTML site
    | are without the .html extension. Since this breaks local browsing you
    | can leave the setting disabled, and instead add the --pretty-urls flag
    | when running the php hyde build command for deployment.
    |
    | Note that this can cause issues when you are serving from a subdirectory.
    | See https://github.com/hydephp/develop/issues/228
    |
    */

    'pretty_urls' => false,

    /*
    |--------------------------------------------------------------------------
    | Sitemap Generation
    |--------------------------------------------------------------------------
    |
    | When the setting is enabled, a sitemap.xml file will automatically be
    | generated when the site is built.
    |
    | This feature requires that a site base URL has been set.
    |
    */

    'generate_sitemap' => true,

    /*
    |--------------------------------------------------------------------------
    | RSS Feed Generation
    |--------------------------------------------------------------------------
    |
    | When enabled, an RSS feed with your Markdown blog posts will be
    | generated when you compile your static site.
    |
    | This feature requires that a site base URL has been set.
    |
    */

    // Should the RSS feed be generated?
    'generate_rss_feed' => true,

    // What filename should the RSS file use?
    'rss_filename' => 'feed.xml',

    // The channel description. By default this is "Site Name + RSS Feed".
    // 'rss_description' => '',

    /*
    |--------------------------------------------------------------------------
    | Site Language
    |--------------------------------------------------------------------------
    |
    | This value sets the language of your site and is used for the
    | <html lang=""> element in the app layout. Default is 'en'.
    |
    */

    'language' => 'en',

    /*
    |--------------------------------------------------------------------------
    | Site Output Directory
    |--------------------------------------------------------------------------
    |
    | This setting specifies the output path for your site, useful to for
    | example, store the site in the docs/ directory for GitHub Pages.
    | The path is relative to the root of your project.
    |
    */

    'output_directory' => '_site',

    /*
    |--------------------------------------------------------------------------
    | Media Directory
    |--------------------------------------------------------------------------
    |
    | This setting specifies the directory where your media files are stored.
    | Note that this affects both the source and output directories.
    | The path is relative to the root of your project.
    |
    */

    'media_directory' => '_media',

    /*
    |--------------------------------------------------------------------------
    | Built-in Server
    |--------------------------------------------------------------------------
    |
    | Here you can configure settings for the built-in realtime compiler server.
    |
    */

    'server' => [
        'port' => env('SERVER_PORT', 8080),
        'dashboard' => env('SERVER_DASHBOARD', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Source Root Directory
    |--------------------------------------------------------------------------
    |
    | HydePHP will by default look for the underscored source directories in the
    | root of your project. For example, you might want everything in a 'src'
    | subdirectory. That's easy enough, just set the value below to "src"!
    |
    */

    'source_root' => '',

    /*
    |--------------------------------------------------------------------------
    | Source Directories
    |--------------------------------------------------------------------------
    |
    | The directories you place your content in are important. The directory
    | will be used to determine the proper page type and the templates used.
    | If you are not happy with these defaults, you can change them here.
    | Note that these are relative to the `source_root` setting above.
    |
    */

    'source_directories' => [
        \Hyde\Pages\HtmlPage::class => '_pages',
        \Hyde\Pages\BladePage::class => '_pages',
        \Hyde\Pages\MarkdownPage::class => '_pages',
        \Hyde\Pages\MarkdownPost::class => '_posts',
        \Hyde\Pages\DocumentationPage::class => '_docs',
    ],

    /*
    |--------------------------------------------------------------------------
    | Output Directories
    |--------------------------------------------------------------------------
    |
    | Like the source directories, the output directories are also important
    | as they determine the final output path for each page type in your
    | compiled static site. This change also affects the route keys.
    |
    | Note that these are relative to the site's `output_directory` setting.
    | Setting the value to '' will output the page to the root of the site.
    |
    */

    'output_directories' => [
        \Hyde\Pages\HtmlPage::class => '',
        \Hyde\Pages\BladePage::class => '',
        \Hyde\Pages\MarkdownPage::class => '',
        \Hyde\Pages\MarkdownPost::class => 'posts',
        \Hyde\Pages\DocumentationPage::class => 'docs',
    ],

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
        Meta::name('generator', 'HydePHP '.Hyde\Hyde::version()),
        Meta::property('site_name', env('SITE_NAME', 'HydePHP')),
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
        Features::htmlPages(),
        Features::markdownPosts(),
        Features::bladePages(),
        Features::markdownPages(),
        Features::documentationPages(),

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
            'mr_hyde', // Required username
            'Mr. Hyde', // Optional display name
            'https://hydephp.com' // Optional website URL
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | Footer Text
    |--------------------------------------------------------------------------
    |
    | Here you can customize the footer Markdown text for your site.
    |
    | If you don't want to write Markdown here, you use a Markdown include.
    | You can also customize the Blade view if you want a more complex footer.
    | You can disable it completely by changing the setting to `false`.
    |
    | To read about the many configuration options here, visit:
    | https://hydephp.com/docs/master/customization#footer
    |
    */

    'footer' => 'Site proudly built with [HydePHP](https://github.com/hydephp/hyde) 🎩',

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
        // The array key should match the page's route key (slug).
        // Lower values show up first in the menu.
        'order' => [
            'index' => 0,
            'posts' => 10,
            'docs/index' => 100,
        ],

        // In case you want to customize the labels for the menu items, you can do so here.
        // Simply add the route key (slug) as the key, and the label as the value.
        'labels' => [
            'index' => 'Home',
            'docs/index' => 'Docs',
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

        // How should pages in subdirectories be displayed in the menu?
        // You can choose between 'dropdown', 'flat', and 'hidden'.
        'subdirectories' => 'hidden',
    ],

    /*
    |--------------------------------------------------------------------------
    | Load app.css from CDN
    |--------------------------------------------------------------------------
    |
    | Hyde ships with an app.css file containing compiled TailwindCSS styles
    | in the _media/ directory. If you want to load this file from the
    | HydeFront JsDelivr CDN, you can set this setting to true.
    |
    */

    'load_app_styles_from_cdn' => false,

    /*
     |--------------------------------------------------------------------------
     | Tailwind Play CDN
     |--------------------------------------------------------------------------
     |
     | The next setting enables a script for the TailwindCSS Play CDN which will
     | compile CSS in the browser. While this is useful for local development
     | it's not recommended for production use. To keep things consistent,
     | your Tailwind configuration file will be injected into the HTML.
     */

    'use_play_cdn' => false,
];
