<?php

/*
|--------------------------------------------------------------------------
| Markdown Configuration
|--------------------------------------------------------------------------
|
| HydePHP makes heavy use of Markdown. In this file you can configure
| Markdown related services, as well as change the extensions used.
|
*/

return [

    /*
    |--------------------------------------------------------------------------
    | Markdown Extensions
    |--------------------------------------------------------------------------
    |
    | Define any extra extensions that should be loaded into the CommonMark
    | converter. Should be fully qualified class names to the extension.
    |
    | Remember that you may need to install any third party extensions
    | through Composer before you can use them.
    |
    | Hyde ships with the GitHub Flavored Markdown extension.
    | The Torchlight extension is enabled automatically when needed.
    |
    */

    'extensions' => [
        \League\CommonMark\Extension\GithubFlavoredMarkdownExtension::class,
        \League\CommonMark\Extension\Attributes\AttributesExtension::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuration Options
    |--------------------------------------------------------------------------
    |
    | Define any options that should be passed to the CommonMark converter.
    |
    | Hyde handles many of the options automatically, but you may want to
    | override some of them and/or add your own. Any custom options
    | will be merged with the Hyde defaults during runtime.
    |
    */

    'config' => [
        //
    ],

    /*
    |--------------------------------------------------------------------------
    | Allow all HTML tags
    |--------------------------------------------------------------------------
    |
    | HydePHP uses the GitHub Flavored Markdown extension to convert Markdown.
    | This, by default strips out some HTML tags. If you want to allow all
    | arbitrary HTML tags, and understand the risks involved, you can
    | use this config setting to enable all HTML tags.
    |
    */

    'allow_html' => false,

    /*
    |--------------------------------------------------------------------------
    | Blade-supported Markdown
    |--------------------------------------------------------------------------
    |
    | This feature allows you to use basic Laravel Blade in Markdown files.
    |
    | It's disabled by default since can be a security risk as it allows
    | arbitrary PHP to run. But if your Markdown is trusted, try it out!
    |
    | To see the syntax and usage, see the documentation:
    | @see https://hydephp.com/docs/1.x/advanced-markdown#blade-support
    |
    */

    'enable_blade' => false,

    /*
    |--------------------------------------------------------------------------
    | Tailwind Typography Prose Classes
    |--------------------------------------------------------------------------
    |
    | HydePHP uses Tailwind Typography to style rendered Markdown.
    |
    | This setting controls the base classes to apply to all the HTML elements
    | containing rendered markdown. Please note that if you add any new
    | classes, you may need to recompile your CSS file.
    |
    */

    'prose_classes' => 'prose dark:prose-invert',

    /*
    |--------------------------------------------------------------------------
    | Heading Permalinks Configuration
    |--------------------------------------------------------------------------
    |
    | Here you can specify which page classes should have heading permalinks.
    | By default, only documentation pages have permalinks enabled, but you
    | are free to enable it for any kind of page by adding the page class.
    |
    */

    'permalinks' => [
        'pages' => [
            \Hyde\Pages\DocumentationPage::class,
        ],
    ],

];
