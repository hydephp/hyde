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
    | Setting a base URL is highly reccomended, and is required to use some
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
    | Site Output Directory (Experimental 🧪)
    |--------------------------------------------------------------------------
    |
    | This setting specifies the output path for your site, useful to for
    | example, store the site in the docs/ directory for GitHub Pages.
    | The path is relative to the root of your project.
    |
    | To use an absolute path, or just to learn more, see the following:
    | https://hydephp.com/docs/master/advanced-customization#customizing-the-output-directory-
    |
    */

    'output_directory' => '_site',

];
