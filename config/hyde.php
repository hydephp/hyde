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
    | Site URL
    |--------------------------------------------------------------------------
    |
    | If you want, you can set your site's URL here or in the .env file.
    |
    | The URL will then be used in meta tags to create permalinks.
    | If you are serving your site from a subdirectory, you will
    | need to include that in the path without a trailing slash.
    |
    | Example: https://example.org/blog
    |
    */

    'site_url' => env('SITE_URL', null),

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
        // Meta::name('twitter:creator', '@hyde_php'),
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

        // Integrations
        Features::torchlight(),
    ],

    /*
    |--------------------------------------------------------------------------
    | Asset Locations and Versions
    |--------------------------------------------------------------------------
    |
    | Since v0.15.0, the default Hyde styles are no longer included as
    | publishable resources. This is to make updating easier, and to
    | reduce complexity. Instead, the assets are loaded through the
    | jsDelivr CDN.
    |
    | The CDN version is defined in the AssetService class,
    | but can be changed here to a valid HydeFront tag.
    |
    | If you load HydeFront through Laravel Mix using the NPM package,
    | you should disable the HydeFront CDN feature.
    |
    */

    'loadHydeAssetsUsingCDN' => true,
    // 'cdnVersionOverride' => 'v1.0.0',

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

    'navigationMenuLinks' => [
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

    'navigationMenuBlacklist' => [
        '404',
    ],

    /*
    |--------------------------------------------------------------------------
    | Documentation Sidebar Header Name
    |--------------------------------------------------------------------------
    |
    | By default, the sidebar title shown in the documentation page layouts uses
    | the app name suffixed with "docs". You can change it with this setting.
    |
    */

    'docsSidebarHeaderTitle' => $siteName.' Docs',

    /*
    |--------------------------------------------------------------------------
    | Documentation Site Output Directory
    |--------------------------------------------------------------------------
    |
    | If you want to store the compiled documentation pages in a different
    | directory than the default 'docs' directory, for example to set the
    | specified version, you can specify the directory here.
    |
    | Note that you need to take care as to not set it to something that
    | may conflict with other parts, such as media or posts directories.
    |
    | The default value is 'docs'.
    |
    */

    /**
     * @deprecated version 0.25.0, will be renamed to documentationOutputPath
     */
    'docsDirectory' => 'docs',

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

    'siteOutputPath' => Hyde\Framework\Hyde::path('_site'),

    /*
    |--------------------------------------------------------------------------
    | Documentation Sidebar Page Order
    |--------------------------------------------------------------------------
    |
    | In the generated Documentation pages the navigation links in the sidebar
    | are sorted alphabetically by default. As this rarely makes sense, you
    | can reorder the page slugs in the list and the links will be sorted
    | in that order. Link items without an entry here will have fall
    | back to the default priority of 999, putting them last.
    |
    */

    'documentationPageOrder' => [
        'readme',
        'installation',
        'getting-started',
    ],

    /*
    |--------------------------------------------------------------------------
    | Documentation Table of Contents Settings
    |--------------------------------------------------------------------------
    |
    | The Hyde Documentation Module comes with a fancy Sidebar that, by default,
    | has a Table of Contents included. Here, you can configure its behavior,
    | content, look and feel. You can also disable the feature completely.
    |
    */

    'documentationPageTableOfContents' => [
        'enabled' => true,
        'minHeadingLevel' => 2,
        'maxHeadingLevel' => 4,
        'smoothPageScrolling' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Pretty URLs (Links that do not end in .html)
    |--------------------------------------------------------------------------
    |
    | Introduced in v0.25.0, you can now enable "pretty URLs". When the setting
    | is enabled, generated links in the compiled HTML site are without the
    | `.html` extension. Since this breaks local browsing you can leave
    | the setting disabled, and instead add the `--pretty-urls` flag
    | when running the `php hyde build` command for deployment.
    |
    */

    'prettyUrls' => false,

    /*
    |--------------------------------------------------------------------------
    | Hyde Config Version @HydeConfigVersion 0.1.0
    |--------------------------------------------------------------------------
    |
    | Hyde can use the value above to determine if this configuration file
    | contains the latest config options. If your config needs updating,
    | a message will be shown in the HydeCLI, unless disabled below.
    |
    */

    'warnAboutOutdatedConfig' => true,

];
