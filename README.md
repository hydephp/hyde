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

HydePHP is a content-first Laravel-powered Static Site Builder that allows you to create static HTML pages, blog posts, and documentation sites using Markdown, optionally with YAML Front Matter.

Need more control? You can also use Laravel Blade to get the full power of dynamic templating and absolute control over HTML.

Hyde is modular, configurable, and hackable - allowing you to customize everything - but only if you want to. Hyde follows convention over configuration, allowing you to get an awesome blog or a smooth documentation site up and running in mere minutes. All the TailwindCSS and Blade templates you need for your site are already configured.

Write a lot of code examples? Hyde automatically enables [Torchlight.dev](https://torchlight.dev/) highlighting for you when you add an API token in the `.env` file.

See the documentation and learn more at https://hydephp.github.io/docs/

## Features

### Create content faster than ever

Hyde comes preinstalled with a responsive TailwindCSS starter kit for static pages, blogs, and documentation sites alike. It has dark mode support, is mobile-friendly, and is accessible to screen readers.

Just write your content in Markdown, and Hyde will automatically generate the site from it. Depending on what folder you stored the Markdown file in, Hyde will choose the appropriate layout from one of the many built-in templates.

For example, storing a file in the `_posts` directory will render the Markdown HTML in a Blog Post template with strong support for Front Matter. Files in the `_docs` directory use the Documentation Page layout with an automatic sidebar. Markdown files in the `_pages` directory are rendered into a simple blank page putting the focus on your content. When using Blade pages you can choose which layout to use, or create your own!

### No messing with routes, links, etc.

Hyde automatically creates and populates navigation menus and documentation sidebars.

All internal links use relative links that automatically get the appropriate level of `../`'s depending on the file path.

For example, if you create a Markdown file as `_pages/about-us.md`, an 'About Us' link will be added to the navigation menu automatically.

### You're not limited to just Markdown
There may be times when you need more control than Markdown can offer. In this case, you can create pages using Laravel Blade. You can extend the default layout to take advantage of the built-in styles and components as well as the dynamic PHP templating, or if you prefer, stick with vanilla HTML. Hyde will compile it to a static page. And of course, you can mix and match between Markdown and Blade as you wish.

## Live Demo & Media
### The Hyde Website
The Hyde site (https://hydephp.github.io/) is fully built with Hyde. That includes the homepage, the blog, and the documentation.

### Demo video showcasing how to scaffold a blog post and compile it to static HTML
[<img src="https://user-images.githubusercontent.com/95144705/163691183-bbf7c005-787c-4257-a7bc-5a413c5e6ee3.png" title="Watch on YouTube" alt="YouTube Thumbnail" width="600px"></img>](https://www.youtube.com/watch?v=gjpE1U527h8)


## Getting Started - High-level overview
> See [Installation Guide](https://hydephp.github.io/docs/master/installation.html) and [Getting Started](https://hydephp.github.io/docs/master/getting-started.html) for the full details.

It's a breeze to get started with Hyde. Create a new Hyde project using Composer:

```bash
composer create-project hyde/hyde
```

Next, place Markdown or Blade files in the content directories: `_posts`, `_docs`, and `_pages`. You can even use full Blade views in the `_pages` directory.

You can scaffold files using the `hyde make` command.
```bash
php hyde make:page|post
```

Next, run the build command to compile your static site:
```bash
php hyde build
```
Your website HTML files are saved in the `_site` directory and are ready to be served!

## ⚠ Beta Software Warning 
Heads up! HydePHP is very new and currently in beta. Please report any bugs and issues in the appropriate issue tracker. Versions in the 0.x series are not stable and may change at any time. No backwards compatibility guarantees are made and there will be breaking changes without notice.

Please wait until v1.0 for production use and remember to back up your source files before updating (use Git!).
See https://hydephp.github.io/docs/master/updating-hyde.html for the upgrade guide.

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
