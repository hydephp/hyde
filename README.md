# HydePHP - Static Blog Builder using Laravel Zero

<p>
	<a href="https://packagist.org/packages/hyde/hyde"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/packagist/v/hyde/hyde" alt="Latest Version on Packagist"></a>
	<a href="https://packagist.org/packages/hyde/hyde"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/packagist/dt/hyde/hyde" alt="Total Downloads"></a>
	<a href="https://github.com/hydephp/hyde/blob/master/LICENSE.md"><img style="display: inline; margin: 4px 2px;" src="https://img.shields.io/github/license/hydephp/hyde" alt="License"></a>
	<img style="display: inline; margin: 4px 2px;" src="https://github.com/hydephp/hyde/actions/workflows/tests.yml/badge.svg" alt="GitHub Actions">
	<img style="display: inline; margin: 4px 2px;" src="https://github.com/hydephp/hyde/actions/workflows/codeql-analysis.yml/badge.svg" alt="GitHub Actions">
</p>

## ⚠ Alpha Software Warning ⚠
### This is a very new repo that has been made public to run further tests before the initial release. Please wait until v1.0 for production use.
---

> This repo both contains the source code and serves as a template to get started quickly.

HydePHP is a Static Site Builder focused on making Blog posts easy and fun. Under the hood, it is powered by Laravel Zero which is a stripped-down version of the robust Laravel Framework. Using Blade templates the site is intelligently compiled into static HTML. Content is created using Markdown, which supports YAML Front Matter.

Hyde is inspired by JekyllRB and is created for Developers who are comfortable writing posts in Markdown. It requires virtually no configuration out of the box as it favours convention over configuration. Though you can easily modify settings in the config/hyde.php to personalize your site. You can also directly modify the Blade views to make them truly yours.

The frontend uses a lightweight minimalist layout built with TailwindCSS which you can extend with the Blade components.

Hyde is designed to be stupidly simple to get started with, while also remaining easily hackable and extendable.

## Installation
> Full installation guide is in the documentation at https://hydephp.github.io/docs/

The recommended method of installation is using Composer. However, if you want to run the latest development version you can clone the Git repo.

### Using Composer (recommended)
```bash
composer create-project hyde/hyde
```

### Requirements 
> These requirements are for your local development environment. The static HTML can be hosted virtually anywhere, including on GitHub Pages.
Hyde uses Laravel 9 which requires PHP >= 8.0. You should also have Composer and NPM installed.


## Getting Started
It's a breeze to get started. Simply clone the repository, write your Markdown posts and save them to the _posts directory and run the `php hyde build` command. You can scaffold post files using the `php hyde make:post` command.

### Usage

Full usage guide is in the documentation at https://hydephp.github.io/docs/

#### Building the static site

Then to compile the site into static HTML all you have to do is execute the Hyde build command.
```bash
php hyde build
```

Your site will then be saved in the _site directory, which you can then upload to your static web host.
All links use relative paths, so you can deploy to a subdirectory without any problems.
The site also works great when browsing the HTML files locally.

If it is the first time building the site or if you have updated the source SCSS you also need to run `npm install && npm run dev` to build the frontend assets.


#### Live preview
Use ` npm run watch` to watch the files for changes and start up a local dev server on port 3000 using Browsersync.

### NPM Commands
See all commands in the documentation [Console Commands](https://hydephp.github.io/docs/docs/console-commands.html)

### Hacking Hyde
Hyde is designed to be easy to use and easy to hack. You can modify the source views and SCSS, customize the Tailwind config, and you can even create 100% custom HTML and Blade pages that get compiled into static HTML.

## Extensions
Hyde comes with built-in support for Torchlight Syntax Highlighting.
All you need to do is to set your API token in your .env file and
Hyde will automatically enable the CommonMark extension.

> Note that when using Torchlight the pages will take longer to generate as API calls need to be made.
> However, Torchlight caches the response so this only affects the first time running the build, or 
> if you update the page.

## Known Issues
Deleting Markdown posts does not delete the already compiled HTML files.
In a future update (coming soon(tm)) the builder will remove unused files automatically.
For now, you can manually delete the files and then run the build command.

Currently, only top-level custom pages are supported. In the future, nested pages will be supported.
For example, _site/directory/page.html

Hyde also currently does not support images, but will soon as it already has the foundation in place to do so.

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing
Roadmap:
Eventually I want to extract the source code into a seperate Framework package. However there needs to be some work done first to make sure the proper filepaths are used.

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email caen@desilva.se instead of using the issue tracker.
All vulnerabilities will be promptly addressed.

## Credits

-   [Caen De Silva](https://github.com/caendesilva)
-   [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

## Attributions
> Please see the respective authors' repositories for their license files

- The Hyde core is built with [Laravel Zero](https://laravel-zero.com/) which is based on [Laravel](https://laravel.com/)
- The frontend is built with [TailwindCSS](https://tailwindcss.com/) with components from [Flowbite](https://flowbite.com/docs/customize/dark-mode/).
- The default favicon was created using [Favicon.io](https://favicon.io/) using an icon from the amazing open-source project [Twemoji](https://twemoji.twitter.com/). The graphics are copyright 2020 Twitter, Inc and other contributors and are licensed under [CC-BY 4.0](https://creativecommons.org/licenses/by/4.0/).
