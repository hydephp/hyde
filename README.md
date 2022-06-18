# HydePHP - Elegant and Powerful Static App Builder

<p> 
    <a href="https://packagist.org/packages/hyde/framework"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/packagist/v/hyde/framework?include_prereleases" alt="Latest Version on Packagist"></a> 
    <a href="https://packagist.org/packages/hyde/framework"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/packagist/dt/hyde/framework" alt="Total Downloads on Packagist"></a> 
    <a href="https://github.com/hydephp/hyde/blob/master/LICENSE.md"> <img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/github/license/hydephp/hyde" alt="License MIT"> </a>
    <a href="https://cdn.desilva.se/microservices/coverbadges/badges/9b8f6a9a7a48a2df54e6751790bad8bd910015301e379f334d6ec74c4c3806d1.svg"><img style="display: inline; margin: 4px 2px;" src="https://cdn.desilva.se/microservices/coverbadges/badges/9b8f6a9a7a48a2df54e6751790bad8bd910015301e379f334d6ec74c4c3806d1.svg" alt="Test Coverage" title="Average coverage between categories"></a>
    <a href="https://github.com/hydephp/develop/actions/workflows/continuous-integration.yml"><img style="display: inline; margin: 4px 2px;" src="https://github.com/hydephp/develop/actions/workflows/continuous-integration.yml/badge.svg" alt="Test Suite"></a>
</p>


## Make static websites, blogs, and documentation pages with the tools you already know and love.

### About HydePHP
HydePHP is a content-first Laravel-powered Static Site Builder that allows you to create static HTML pages, blog posts, and documentation sites,
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


## Live Demo & Media
### The Hyde Website
The Hyde site (https://hydephp.com/) is fully built with Hyde. That includes the homepage, the blog, and the documentation.
You can also take a look at the [Gallery page](https://hydephp.com/gallery) which was created using the Blade page module in Hyde and contains interactive graphics showcasing Hyde.

### Demo video showcasing how to scaffold a blog post and compile it to static HTML
[<img src="https://user-images.githubusercontent.com/95144705/163714609-8d636acd-3538-47e9-a6f3-1923b375338b.png" title="Watch on YouTube" alt="YouTube Thumbnail" width="40%"></img>](https://www.youtube.com/watch?v=gjpE1U527h8)

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

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

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
- The documentation frontend is based on [Lagrafo - Docs for Laravel apps](https://github.com/caendesilva/lagrafo)
- The dark mode switch is based on a component from [Flowbite](https://flowbite.com/docs/customize/dark-mode/).
- The frontend is built with [TailwindCSS](https://tailwindcss.com/).
