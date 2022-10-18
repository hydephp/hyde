# HydePHP - Elegant and Powerful Static Site Generator


[![Latest Version on Packagist](https://img.shields.io/packagist/v/hyde/framework?include_prereleases)](https://packagist.org/packages/hyde/framework) 
[![Total Downloads on Packagist](https://img.shields.io/packagist/dt/hyde/framework)](https://packagist.org/packages/hyde/framework) 
[![License MIT](https://img.shields.io/github/license/hydephp/hyde) ](https://github.com/hydephp/hyde/blob/master/LICENSE.md)
[![Test Coverage](https://codecov.io/gh/hydephp/develop/branch/master/graph/badge.svg?token=G6N2161TOT)](https://codecov.io/gh/hydephp/develop)
[![Test Suite](https://github.com/hydephp/develop/actions/workflows/continuous-integration.yml/badge.svg)](https://github.com/hydephp/develop/actions/workflows/continuous-integration.yml)


## Make static websites, blogs, and documentation pages with the tools you already know and love.

### About HydePHP
HydePHP is a content-first Laravel-powered console application that allows you to create static HTML pages, blog posts, and documentation sites,
using your choice of Markdown and/or Blade.

Build sites in record-time with a full batteries-included TailwindCSS frontend that just works without any fuzz.

### Speed & simplicity first, full control when you need it.
Hyde is all about letting you get started quickly by giving you a full-featured frontend starter kit, while also giving you the power and freedom of doing things the way you want to.

Markdown purist? That's all you need. Blade artisan? Go for it.
Hyde comes with hand-crafted frontend templates so you can focus on your content.
You don't _need_ to customize anything. But you _can_ customize everything.

See the documentation and learn more at https://hydephp.com/docs/

## Features

### Content Creation
- Create blog posts using Markdown and Front Matter.
- Create documentation pages from plain Markdown, no front matter needed!
- Create simple pages using Markdown, or create advanced ones using Laravel Blade.
- You can scaffold blog posts and Markdown pages to automatically fill in the front matter.
- You can also scaffold Blade pages to automatically use the default layout.

### Built-in Frontend
- Hyde comes with a TailwindCSS starter kit so you can start making content right away.
- The starter kit is fully responsive, has a dark mode theme, and is customizable.
- The frontend is accessible to screenreaders and rich with semantic HTML and microdata. 
- Hyde automatically chooses the right layout to use depending on the content being rendered.
- Hyde also fills in and creates content like navigation menus and sidebars automatically.

### Easy Asset Managing
- The Hyde starter comes with [HydeFront](https://github.com/hydephp/hydefront/) to serve the base stylesheet and JavaScript through the jsDelivr CDN.
- Hyde ships with precompiled and minified TailwindCSS styles in the app.css file, you can also load them through the CDN.
- This means that all the styles you need are already installed. However, if you want to customize the Tailwind config, or if you add new Tailwind classes through Blade files, you can simply run the `npm run dev` command to recompile the styles using Laravel Mix.

### Customization
- You don't need to configure anything as Hyde is shipped with sensible defaults.
- You can, however, customize nearly everything. Here are some examples:
- All frontend components and page layouts are created with Blade so you 
  can publish the vendor views, just like in Laravel.
- Override many of the dynamic content features like the menus and footer.

## Getting Started - High-level overview
> See [Installation Guide](https://hydephp.com/docs/master/installation.html) and [Getting Started](https://hydephp.com/docs/master/getting-started.html) for the full details.

It's a breeze to get started with Hyde. Create a new Hyde project using Composer:

```bash
composer create-project hyde/hyde
```

Next, place your Markdown files in one of the content directories:  `_posts`, `_docs`, and `_pages` which also accepts Blade files. You can also use use the `hyde:make` command to scaffold them.

When you're ready, run the build command to compile your static site which will save your HTML files in the `_site` directory.

```bash
php hyde build
```

## ⚠ Beta Software Warning 
Heads up! HydePHP is still new and currently in beta. Please report any bugs and issues in the appropriate issue tracker. Versions in the 0.x series might not be stable and may change at any time. No backwards compatibility guarantees are made and there will be breaking changes without notice.

Please wait until v1.0 for production use and remember to back up your source files before updating (use Git!).
See https://hydephp.com/docs/master/updating-hyde for the upgrade guide.

## Resources

### Changelog 

Please see [CHANGELOG](https://github.com/hydephp/develop/blob/master/CHANGELOG.md) for more information on what has changed recently.

### Contributing

HydePHP is an open-source project, contributions are very welcome!

Development is made in the HydePHP Monorepo, which you can find here https://github.com/hydephp/develop.

### Security

If you discover any security-related issues, please email caen@desilva.se instead of using the issue tracker.
All vulnerabilities will be promptly addressed.

### Credits

-   [Caen De Silva](https://github.com/caendesilva), feel free to buy me a coffee! https://www.buymeacoffee.com/caen
-   [All Contributors](../../contributors)

### License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

### Attributions
> Please see the respective authors' repositories for their license files

- The Hyde core is built with [Laravel Zero](https://laravel-zero.com/) which is based on [Laravel](https://laravel.com/)
- The documentation frontend was originally based on [Lagrafo - Docs for Laravel apps](https://github.com/caendesilva/lagrafo)
- The dark mode switch is based on a component from [Flowbite](https://flowbite.com/docs/customize/dark-mode/).
- The frontend is built with [TailwindCSS](https://tailwindcss.com/).
