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
| Welcome to HydePHP! In this file you can customize your new Static Site!
|
| HydePHP favors convention over configuration and as such requires virtually
| no configuration out of the box to get started. Though, you may want to
| change the options to personalize your site and make it your own!
|
*/

use App\Hyde\Features;

return [

	/*
    |--------------------------------------------------------------------------
    | Site Name
    |--------------------------------------------------------------------------
    |
    | This value sets the name of your site and is, for example, used in
    | the compiled page titles and more. Default value is "HydePHP".
    |
    */

    'name' => 'HydePHP',


    /*
    |--------------------------------------------------------------------------
    | Features
    |--------------------------------------------------------------------------
    |
    | Some of Hyde's features are optional. Feel free to disable the features
    | you don't need by removing them from this array or by commenting them.
    | This type of configuration is directly inspired by Laravel Jetstream.
    |
    */

    'features' => [
        Features::blogPosts(),
        Features::bladePages(),
        Features::markdownPages(),
        Features::documentationPages(),
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
        '404'
    ],


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
    ]

];
