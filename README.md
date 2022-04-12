# HydePHP - Static App Builder powered by Laravel

<p> 
    <a href="https://packagist.org/packages/hyde/framework"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/packagist/v/hyde/framework?include_prereleases" alt="Latest Version on Packagist"></a> 
    <a href="https://packagist.org/packages/hyde/framework"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/packagist/dt/hyde/framework" alt="Total Downloads on Packagist"></a> 
    <a href="https://github.com/hydephp/hyde/blob/master/LICENSE.md"> <img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/github/license/hydephp/hyde" alt="License MIT"> </a>
    <img style="display: inline; margin: 4px 2px;" src="https://cdn.desilva.se/microservices/coverbadges/badges/9b8f6a9a7a48a2df54e6751790bad8bd910015301e379f334d6ec74c4c3806d1.svg" alt="Test Coverage" title="Average coverage between categories">
    <img style="display: inline; margin: 4px 2px;" src="https://github.com/hydephp/hyde/actions/workflows/tests.yml/badge.svg" alt="GitHub Actions"> <img style="display: inline; margin: 4px 2px;" src="https://github.com/hydephp/hyde/actions/workflows/codeql-analysis.yml/badge.svg" alt="CodeQL Analysis"> 
    <a href="https://github.styleci.io/repos/472503421?branch=master"> <img style="display: inline; margin: 4px 2px;" src="https://github.styleci.io/repos/472503421/shield?branch=master" alt="StyleCI Status"> </a>
</p>

## Make static websites, blogs, and documentation pages with the tools you already know and love.
---

## ⚠ Beta Software Warning ⚠
### Heads up! HydePHP is still very new. As such there may be bugs (please report them) and breaking changes.
#### Please wait until v1.0 for production use and remember to backup your source files before updating (use Git!).
---

## About

HydePHP is a content-first Laravel-powered Static Site Builder that allows you to create static HTML pages, blog posts, and documentation sites using Markdown, optionally with YAML Front Matter.

Need more control? You can also use Laravel Blade to get the full power of dynamic templating and absolute control over HTML.

Hyde is modular, configurable, and hackable - allowing you to customize everything - but only if you want to. Hyde follows convention over configuration, allowing you to get an awesome blog or a smooth documentation site up and running in mere minutes. All the TailwindCSS and Blade templates you need for your site are already configured.

See the documentation and learn more at https://hydephp.github.io/docs/

## Live Demo
The Hyde site (https://hydephp.github.io/) is fully built with Hyde. That includes the homepage, the blog, and the documentation.

## Installation Quick Start
The recommended method of installation is using Composer.

```bash
composer create-project hyde/hyde --stability=dev
```

> Full installation guide is at https://hydephp.github.io/docs/master/installation.html

## Getting Started - High-level overview
It's a breeze to get started. After creating a new Hyde project, place Markdown or Blade files in the content directories, run the build command, and you're ready to upload your site to your host, or GitHub Pages.

### Writing content
You can create content using Markdown by placing the files in and of the following directories: `_pages`, `_posts`, and `_docs`.

If you want to use Blade templates, you can place the views in the '_pages' directory.

You can scaffold files using the `hyde make` command.
```bash
php hyde make:post # Automatically creates the front matter
php hyde make:page "Page Title" [--type="markdown/blade"]
```

### Build the static site

Compile the static site using the `hyde build` command.
```bash
php hyde build # Compile the static site
php hyde rebuild _posts/example.md # Or, compile a single file
```

> See the [console command docs](https://hydephp.github.io/docs/master/console-commands.html) for more information on the HydeCLI.



## Hacking Hyde
Hyde is designed to be easy to use and easy to customize and hack. See [Hacking Hyde](https://hydephp.github.io/docs/master/index.html#hacking-hyde) for more. 

### Extensions
Hyde comes with built-in support for Torchlight Syntax Highlighting.
All you need to do is to set your API token in your .env file and
Hyde will automatically enable the CommonMark extension.


## Resources

### Changelog 

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

### Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

### Security

If you discover any security-related issues, please email caen@desilva.se instead of using the issue tracker.
All vulnerabilities will be promptly addressed.

### Credits

-   [Caen De Silva](https://github.com/caendesilva)
-   [All Contributors](../../contributors)

### License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

### Attributions
> Please see the respective authors' repositories for their license files

- The Hyde core is built with [Laravel Zero](https://laravel-zero.com/) which is based on [Laravel](https://laravel.com/)
- The frontend is built with [TailwindCSS](https://tailwindcss.com/).
- The dark mode switch is based on a component from [Flowbite](https://flowbite.com/docs/customize/dark-mode/).
- Icons are from [Google Material Icons](https://material.io/resources/icons/). License Apache 2.0
