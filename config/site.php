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
    | To see the full documentation, please visit the documentation link below.
    | https://hydephp.com/docs/master/customization#site-url-configuration
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
    | Navigation Menu Configuration
    |--------------------------------------------------------------------------
    |
    | If you are looking to customize the navigation menu links, this is the place!
    |
    | See the documentation for the full list of options:
    | https://hydephp.com/docs/master/customization#navigation-menu--sidebar
    |
    */

    /*
    |--------------------------------------------------------------------------
    | Site Output Directory (Experimental 🧪)
    |--------------------------------------------------------------------------
    |
    | This setting specifies the output path for your site, useful to for
    | example, store the site in the docs/ directory for GitHub Pages.
    | The path is relative to the root of your project.
    |
    | To use an absolute path, or just to learn more:
    | @see https://hydephp.com/docs/master/advanced-customization#customizing-the-output-directory-
    |
    */

    'output_directory' => '_site',

];
