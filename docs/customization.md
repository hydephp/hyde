---
label: "Customizing your Site"
priority: 25
category: "Digging Deeper"
---

# Customizing your Site

## Introduction

Hyde favours <a href="https://en.wikipedia.org/wiki/Convention_over_configuration">"Convention over Configuration"</a>
and thus comes preconfigured with sensible defaults. However, Hyde also strives to be modular and endlessly customizable hackable if you need it. This page guides you through the endless options available!


## Main Configuration File
The main configuration file is in `config/hyde.php`. The [config file](https://github.com/hydephp/hyde/blob/master/config/hyde.php) is fully documented, so I recommend you take a look to see all the options.

In this config file, you can customize the site name, what modules to enable, and programmatically customize the navigation menu and documentation sidebar. 

Here are a few examples of the config options.

### Modules
With a concept directly inspired by [Laravel Jetstream](https://jetstream.laravel.com/), this setting allows you to toggle various modules.
```php
// torchlight! {"lineNumbers": false}
'features' => [
    Features::blogPosts(),
    Features::bladePages(),
    Features::markdownPages(),
    // Features::documentationPages(),
],
```

### Authors
Hyde has support for adding authors in front matter, for example to
automatically add a link to your website or social media profiles.
However, it's tedious to have to add those to each and every
post you make, and keeping them updated is even harder.

You can predefine authors in the Hyde config.
When writing posts, just specify the username in the front matter,
and the rest of the data will be pulled from a matching entry.

#### Example
// torchlight! {"lineNumbers": false}
```php
'authors' => [
    Author::create(
        username: 'mr_hyde', // Required username
        name: 'Mr. Hyde', // Optional display name
        website: 'https://hydephp.com' // Optional website URL
    ),
],
```

This is equivalent to the following front matter:
```yaml
author:
    username: mr_hyde
    name: Mr. Hyde
    website: https://hydephp.com
```

But you only have to specify the username:
```yaml
author: mr_hyde
```

### Footer
The footer can be customized using Markdown, and even disabled completely.

```php
// torchlight! {"lineNumbers": false}
'footer' => [
  'enabled' => true,
  'markdown' => 'Site built with [HydePHP](https://github.com/hydephp/hyde).'
],
```

### Navigation Menu & Sidebar
One of my (the author's) favourite features with Hyde is its automatic navigation menu and documentation sidebar generator.

#### How it works:
The sidebar works by creating a list of all the documentation pages.

The navigation menu is a bit more sophisticated, it adds all the top-level Blade and Markdown pages. It also adds an automatic link to the docs if there is an `index.md` or `readme.md` in the `_docs` directory.

#### Reordering Items
Sadly, Hyde is not intelligent enough to determine what order items should be in (blame Dr Jekyll for this), so you will probably want to set a custom order.

Reordering items in the documentation sidebar is as easy as can be. In the hyde config, there is an array just for this. When the sidebar is generated it looks through this config array. If a slug is found here it will get priority according to its position in the list. If a page does not exist in the list they get priority 999, which puts them last.

Let's see an example:
```php
// torchlight! {"lineNumbers": false}
// This is the default values in the config. It puts the readme.md first in order.
'documentationPageOrder' => [
    'readme', // This is the first entry, so it gets the priority 0
    'installation', // This gets priority 1
    'getting-started', // And this gets priority 2
    // Any other pages not listed will get priority 999 
]
```

> Navigation menu items will be ordered in the same way in a coming update, but for now, they can be reordered by overriding them which you can learn in the next section.

#### Adding Custom Navigation Menu Links
> Until the navigation link order is implemented, you can use this feature to reorder navigation menu items.

The links are added in the config/hyde.php file, and the syntax for adding custom links is documented in the config. Here are some examples:

```php
// torchlight! {"lineNumbers": false}
// External link
[
    'title' => 'GitHub',
    'destination' => 'https://github.com/hydephp/hyde',
    'priority' => 1200,
],

// Internal link (Hyde automatically resolves relative paths)
[
    'title' => 'Featured Blog Post',
    'slug' => 'posts/hello-world',
    // The 'priority' is not required.
]
```

#### Removing Items (Blacklist)

Sometimes, especially if you have a lot of pages, you may want to prevent links from showing up in the main navigation menu. To remove items from being automatically added, simply add the slug to the blacklist. As you can see, the `404` page has already been filled in for you.

```php
'navigationMenuBlacklist' => [
    '404'
],
```

> Tip: You can publish the included 404 page using `php hyde publish:404`!

## Blade Views
Hyde uses the Laravel templating system called Blade. Most parts have been extracted into components to be customized easily.

> Before editing Blade views you should familiarize yourself with how they work in the official documentation https://laravel.com/docs/9.x/blade.

To edit the default component you need to publish them first using the `hyde publish:views` command.

The files will then be available in the `resources/views/vendor/hyde` directory.

## Frontend Styles
Hyde is designed to not only serve as a framework but a whole starter kit and comes with a Tailwind starter template for you to get up and running quickly. If you want to customize these, you are free to do so. Please see the [Managing Assets](managing-assets.html) page to learn more.


## CommonMark environment

Hyde uses [League CommonMark](https://commonmark.thephpleague.com/) for converting Markdown into HTML.

Hyde ships with the GitHub Flavored Markdown extension, and 
the Torchlight extension is enabled automatically when needed.

You can add extra CommonMark extensions, or change the default ones, in the `config/markdown.php` file.

```php
'extensions' => [
	\League\CommonMark\Extension\GithubFlavoredMarkdownExtension::class,
	\League\CommonMark\Extension\Attributes\AttributesExtension::class,
	\League\CommonMark\Extension\DisallowedRawHtml\DisallowedRawHtmlExtension::class,
],
```

In the same file you can also change the config to be passed to the CommonMark environment.

```php
'config' => [
	'disallowed_raw_html' => [
		'disallowed_tags' => [],
	],
],
```
