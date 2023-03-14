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
    | Pretty URLs
    |--------------------------------------------------------------------------
    |
    | When the setting is enabled, generated links in the compiled HTML site
    | are without the .html extension, in other words, "pretty" URLs.
    |
    | This setting can also be enabled on a per-compile basis by supplying
    | the `--pretty-urls` option when you run the build command.
    |
    */

    'pretty_urls' => false,

    /*
    |--------------------------------------------------------------------------
    | Sitemap Generation
    |--------------------------------------------------------------------------
    |
    | When the setting is enabled, a sitemap.xml file will automatically be
    | generated when you compile your static site.
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

    'rss' => [
        // Should the RSS feed be generated?
        'enabled' => true,

        // What filename should the RSS file use?
        'filename' => 'feed.xml',

        // The channel description.
        'description' => env('SITE_NAME', 'HydePHP').' RSS Feed',
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
        Meta::name('generator', 'HydePHP v'.Hyde\Hyde::version()),
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
    | https://hydephp.com/docs/1.x/customization#footer
    |
    */

    'footer' => 'Site proudly built with [HydePHP](https://github.com/hydephp/hyde) 🎩',

    /*
    |--------------------------------------------------------------------------
    | Navigation Menu Configuration
    |--------------------------------------------------------------------------
    |
    | If you are looking to customize the main navigation menu, this is the place!
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
            // NavItem::forLink('https://github.com/hydephp/hyde', 'GitHub', 200),
        ],

        // How should pages in subdirectories be displayed in the menu?
        // You can choose between 'dropdown', 'flat', and 'hidden'.
        'subdirectories' => 'hidden',
    ],

    /*
    |--------------------------------------------------------------------------
    | Cache Busting
    |--------------------------------------------------------------------------
    |
    | Any assets loaded using the Asset::mediaLink() helper will automatically
    | have a cache busting query string appended to the URL. This is useful
    | when you want to force browsers to load a new version of an asset.
    |
    | The mediaLink helper is used in the built-in views to load the
    | default stylesheets and scripts, and thus use this feature.
    |
    | To disable cache busting, set this setting to false.
    |
    */

    'enable_cache_busting' => true,

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

    /*
    |--------------------------------------------------------------------------
    | Default Color Scheme
    |--------------------------------------------------------------------------
    |
    | The default color scheme for the meta color-scheme tag, note that this
    | is just a hint to the user-agent and does not force a specific theme.
    |
    */

    'default_color_scheme' => 'light',

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
        'host' => env('SERVER_HOST', 'localhost'),
        'dashboard' => env('SERVER_DASHBOARD', true),
    ],

    /*
    |--------------------------------------------------------------------------
    | Additional Advanced Options
    |--------------------------------------------------------------------------
    |
    | Finally, here are some additional configuration options that you most
    | likely won't need to change. These are intended for advanced users,
    | and some should only be changed if you know what you're doing.
    |
    */

    // The list of directories that are considered to be safe to empty upon site build.
    // If the site output directory is set to a directory that is not in this list,
    // the build command will prompt for confirmation before emptying it.
    'safe_output_directories' => ['_site', 'docs', 'build'],

    // Should a JSON build manifest with metadata about the build be generated?
    'generate_build_manifest' => true,

    // Where should the build manifest be saved? (Relative to project root, for example _site/build-manifest.json)
    'build_manifest_path' => 'app/storage/framework/cache/build-manifest.json',

    // Here you can specify HydeFront version and URL for when loading app.css from the CDN.
    // Only change these if you know what you're doing as some versions may incompatible with your Hyde version.
    'hydefront_version' => \Hyde\Framework\Services\AssetService::HYDEFRONT_VERSION,
    'hydefront_cdn_url' => \Hyde\Framework\Services\AssetService::HYDEFRONT_CDN_URL,

];
