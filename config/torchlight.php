<?php

 /*
|--------------------------------------------------------------------------
| Torchlight
|--------------------------------------------------------------------------
|
| Hyde comes with built-in support for Torchlight.
|
| All you need to do is supply your API token in the TORCHLIGHT_TOKEN .env
| variable and the extension will be enabled automatically for you.
| This config also comes with an extra option to automatically
| inject an attribution badge on pages that use Torchlight.
|
| @see https://torchlight.dev/
|
*/
return [
    // Should an attribution badge be automatically injected,
    // and if so, what (Markdown) text should be used?
    'attribution' => [
        'enabled' => true,
        'markdown' => '
<p>
    <i>
        Syntax highlighting by <a href="https://torchlight.dev/" rel="noopener nofollow">Torchlight.dev</a>
    </i>
</p>',
    ],

    // The Torchlight client caches highlighted code blocks. Here
    // you can define which cache driver you'd like to use. If
    // leave this blank your default app cache will be used.
    'cache' => env('TORCHLIGHT_CACHE_DRIVER'),

    // Cache blocks for 30 days.
    'cache_seconds' => env('TORCHLIGHT_CACHE_TTL', 60 * 60 * 24 * 30),

    // Which theme you want to use. You can find all the themes at
    // https://torchlight.dev/docs/themes.
    'theme' => env('TORCHLIGHT_THEME', 'material-theme-palenight'),

    // If you want to use two separate themes for dark and light modes,
    // you can use an array to define both themes. Torchlight renders
    // both on the page, and you will be responsible for hiding one
    // or the other depending on the dark / light mode via CSS.
    // 'theme' => [
    //     'dark' => 'github-dark',
    //     'light' => 'github-light',
    // ],

    // Your API token from torchlight.dev.
    'token' => env('TORCHLIGHT_TOKEN'),

    // If you want to register the blade directives, set this to true.
    'blade_components' => true,

    // The Host of the API.
    'host' => env('TORCHLIGHT_HOST', 'https://api.torchlight.dev'),

    // We replace tabs in your code blocks with spaces in HTML. Set
    // the number of spaces you'd like to use per tab. Set to
    // `false` to leave literal tabs in the HTML.
    'tab_width' => 4,

    // If you pass a filename to the code component or in a markdown
    // block, Torchlight will look for code snippets in the
    // following directories.
    'snippet_directories' => [
        resource_path(),
    ],

    // Global options to control blocks-level settings.
    // https://torchlight.dev/docs/options
    'options' => [
        // Turn line numbers on or off globally.
        // 'lineNumbers' => false,

        // Control the `style` attribute applied to line numbers.
        // 'lineNumbersStyle' => '',

        // Turn on +/- diff indicators.
        // 'diffIndicators' => true,

        // If there are any diff indicators for a line, put them
        // in place of the line number to save horizontal space.
        // 'diffIndicatorsInPlaceOfLineNumbers' => true,

        // When lines are collapsed, this is the text that will
        // be shown to indicate that they can be expanded.
        // 'summaryCollapsedIndicator' => '...',
    ],
];
