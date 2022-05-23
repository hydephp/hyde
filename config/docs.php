<?php

/*
|--------------------------------------------------------------------------
| Documentation Module Settings
|--------------------------------------------------------------------------
|
| Since the Hyde documentation module has many configuration options,
| they have now been broken out into their own configuration file.
|
*/

return [
    /*
    |--------------------------------------------------------------------------
    | Sidebar Header Name
    |--------------------------------------------------------------------------
    |
    | By default, the sidebar title shown in the documentation page layouts uses
    | the app name suffixed with "docs". You can change it with this setting.
    |
    */

    'header_title' => config('hyde.name', 'HydePHP').' Docs',

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
    | The default value is 'docs'. For easy versioning you can do what
    | HydePHP.com does, setting it to 'docs/master'.
    |
    */

    'output_directory' => 'docs',

    /*
    |--------------------------------------------------------------------------
    | Sidebar Page Order
    |--------------------------------------------------------------------------
    |
    | In the generated Documentation pages the navigation links in the sidebar
    | are sorted alphabetically by default. As this rarely makes sense, you
    | can reorder the page slugs in the list and the links will be sorted
    | in that order. Link items without an entry here will have fall
    | back to the default priority of 999, putting them last.
    |
    | You can also set explicit priorities in front matter.
    |
    */

    'sidebar_order' => [
        'readme',
        'installation',
        'getting-started',
    ],

    /*
    |--------------------------------------------------------------------------
    | Table of Contents Settings
    |--------------------------------------------------------------------------
    |
    | The Hyde Documentation Module comes with a fancy Sidebar that, by default,
    | has a Table of Contents included. Here, you can configure its behavior,
    | content, look and feel. You can also disable the feature completely.
    |
    */

    'table_of_contents' => [
        'enabled' => true,
        'min_heading_level' => 2,
        'max_heading_level' => 4,
    ],
];
