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

return [

    /*
    |--------------------------------------------------------------------------
    | Site Name
    |--------------------------------------------------------------------------
    |
    | This value sets the name of your site and is, for example, used in
    | the compiled page titles and more. The default value is HydePHP.
    |
    | The name is stored in the $siteName variable so it can be
    | used again later on in this config.
    |
    */

    'name' => $siteName = env('SITE_NAME', 'HydePHP'),

    /*
    |--------------------------------------------------------------------------
    | Site URL Configuration
    |--------------------------------------------------------------------------
    |
    | Here are some configuration options for URL generation.
    |
    | A site_url is required to use sitemaps and RSS feeds.
    |
    | `site_url` is used to create canonical URLs and permalinks.
    | `prettyUrls` will when enabled create links that do not end in .html.
    | `generateSitemap` determines if a sitemap.xml file should be generated.
    |
    | To see the full documentation, please visit the (temporary link) below.
    | https://github.com/hydephp/framework/wiki/Documentation-Page-Drafts
    |
    |
    */

    'site_url' => env('SITE_URL', null),

    'pretty_urls' => false,

    'generate_sitemap' => true,

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
        Meta::property('site_name', $siteName),
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
    | Custom Navigation Menu Links
    |--------------------------------------------------------------------------
    |
    | If you are looking to add custom navigation menu links, this is the place!
    |
    | Linking to an external site? Supply the full URI to the 'destination'.
    | Keeping it internal? Pass the 'slug' relative to the document root.
    |
    | To get started quickly, you can uncomment the defaults here.
    | Tip: Only the title and slug parameters are required.
    |
    */

    'navigation_menu_links' => [
        // [
        //     'title' => 'GitHub',
        //     'destination' => 'https://github.com/hydephp/hyde',
        //     'priority' => 1200,
        // ],
        // [
        //     'title' => 'Featured Blog Post',
        //     'slug' => 'posts/hello-world',
        // ]
    ],

    /*
    |--------------------------------------------------------------------------
    | Navigation Menu Blacklist
    |--------------------------------------------------------------------------
    | There may be pages you want to exclude from the automatic navigation menu,
    | such as error pages. Add their slugs here and they will not be included.
    |
    */

    'navigation_menu_blacklist' => [
        '404',
    ],

    /*
    |--------------------------------------------------------------------------
    | Site Output Directory (Experimental 🧪)
    |--------------------------------------------------------------------------
    |
    | If you want to store your compiled website in a different directory than
    | the default `_pages`, you can change the path here. The Hyde::path()
    | helper ensures the path is relative to your Hyde project. While
    | you can set the path to an absolute path outside the project,
    | this is not officially supported and may be unstable.
    |
    */

    'site_output_path' => Hyde\Framework\Hyde::path('_site'),

    /*
    |--------------------------------------------------------------------------
    | Warn about outdated config?
    |--------------------------------------------------------------------------
    |
    | If your config needs updating, a message will be shown in the
    | HydeCLI info screen, unless disabled below.
    |
    */

    'warn_about_outdated_config' => true,

];
