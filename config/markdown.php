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
    | Hyde ships with the Github Flavored Markdown extension.
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
    | Blade-supported Markdown
    |--------------------------------------------------------------------------
    |
    | Since Hyde v0.30.x you can use Laravel Blade in Markdown files.
    |
    | It's disabled by default since can be a security risk as it allows
    | arbitrary PHP to run. But if your Markdown is trusted, try it out!
    |
    | To see the syntax and usage, see the documentation:
    | @see https://hydephp.com/docs/master/advanced-markdown#blade-support
    |
    */

    'enable_blade' => false,
];
