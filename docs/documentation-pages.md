---
label: Documentation Pages
priority: 12
category: "Creating Content"
---

# Creating Documentation Pages

## Introduction to Hyde Documentation Pages

Hyde makes it easier than ever to create documentation sites.
By the way, this documentation site is of course made with the Hyde Documentation module!

In short, all you need to do is put standard Markdown files in the `_docs/` directory and Hyde will do the rest.

What is "the rest", you may ask? Well, for starters:

- Hyde compiles your Markdown content into a beautiful static HTML page based on [the Lagrafo frontend](https://github.com/caendesilva/lagrafo)
- A sidebar (which is responsive) is automatically created based on your Markdown files
  - If you have an `index.md` or `readme.md` in the `_docs/` directory, it will be used as the sidebar header
  - You can even [customize the order and labels](#sidebar-page-order) of sidebar items
- If you have an `index.md` or `readme.md` in the `_docs/` directory,
  a link to it will be added to the site navigation menu named "Docs".
- If you have a Torchlight API token in your .env file, Hyde will even automatically enable Syntax Highlighting for you.
  See more about this in the [extensions page](extensions.html#torchlight).

### Best Practices and Hyde Expectations

Since Hyde does a lot of things automatically, there are some things you may need
to keep in mind when creating blog posts so that you don't get unexpected results.

#### Filenames

- Hyde Documentation pages are files are stored in the `_docs` directory
- The filename is used as the filename for the compiled HTML
- Filenames should use `kebab-case-slug` format, followed by the appropriate extension
- Files prefixed with `_underscores` are ignored by Hyde
- You should always have an `index.md` file in the `_docs/` directory
- Your page will be stored in `_site/docs/<slug>.html` unless you [change it in the config](#output-directory)


## Creating Documentation Pages
You can create a Documentation page by adding a file to the `_docs` directory where the filename ends in `.md`.

You can also scaffold one quickly by using the [HydeCLI](console-commands.html).

```bash
php hyde make:page "Page Title" --type="docs"
```

This will create the following file saved as `_docs/page-title.md`

```markdown
# Page Title
```

### Front Matter is optional

You don't need to use [front matter](blog-posts.html#supported-front-matter-properties) to create a documentation page.

However, Hyde still supports front matter here as it allows you to quickly override the default values.

Here is a quick reference, however, you should take a look at the [dynamic content](#dynamic-content-generation) section to learn more.

```yaml
---
title: "Page Title"
label: "Sidebar Label"
hidden: true
priority: 5
---
```


## Dynamic content generation

Hyde makes documentation pages easy to create by automatically generating dynamic content such as the sidebar and page title.
If you are not happy with the results you can customize them in the config or with front matter.

Before we look at how to override things, here is an overview of the relevant content Hyde generates,
and where the data is from as well as where it can be overridden.


| Property             | Description                                            | Source                         | Override in          |
|----------------------|--------------------------------------------------------|--------------------------------|----------------------|
| `title` (string)     | The title of the page used in the HTML `<title>` tag   | The first H1 heading (`# Foo`) | Front matter         |
| `label` (string)     | The label for the page shown in the sidebar            | The page filename (slug)       | Front matter         |
| `hidden` (boolean)   | Hides the page from the sidebar                        | _null_                         | Front matter         |
| `priority` (integer) | The priority of the page used for ordering the sidebar | Defaults to 999                | Front matter, config |


## Sidebar

The sidebar is automatically generated from the files in the `_docs` directory. You will probably want to change the order
of these items. You can do this in two ways, either in the config or with front matter.

### Table of contents

Hyde automatically generates a table of contents for the page and adds it to the sidebar.

The behaviour of this can be changed in the configuration file.
See [the customization page](customization.html#navigation-menu--sidebar) for more details.


### Sidebar ordering

The sidebar is sorted/ordered by the `priority` property. The higher the priority the further down in the sidebar it will be.
The default priority is 999. You can override the priority using the following front matter:

```yaml
priority: 5
```

You can also change the order in the Docs configuration file.
See [the chapter in the customization page](customization.html#navigation-menu--sidebar) for more details. <br>
 _I personally think the config route is easier as it gives an instant overview, however the first way is nice as well._

### Sidebar labels

The sidebar items are labeled with the `label` property. The default label is the filename of the file.
You can change it with the following front matter:

```yaml
label: "My Custom Sidebar Label"
```

### Sidebar grouping

Sidebar grouping was introduced in Hyde [v0.24.0-beta](https://github.com/hydephp/framework/releases/tag/v0.24.0-beta)
and allows you to group items in the sidebar into categories. This is useful for creating a sidebar with a lot of items.
The Hyde docs for instance use this.

The feature is enabled automatically when one or more of your documentation pages have the category property set
in the front matter. This will then switch to a slightly more compact sidebar layout with pages sorted into categories.
Any pages without the category front matter will get put in the "Other" category.

To enable sidebar grouping, you can add the following front matter to your documentation pages:

```yaml
category: "Getting Started"
```


### Hiding items

You can hide items from the sidebar by adding the `hidden` property to the front matter:

```yaml
hidden: true
```

This can be useful to create redirects or other items that should not be shown in the sidebar.

> The index page is by default not shown as a sidebar item, but instead is linked in the sidebar header. <br>
> In the future, this might be disabled by setting the `hidden` property to `false` in the front matter.

## Customization

Please see the [customization page](customization.html) for in-depth information on how to customize Hyde,
including the documentation pages. Here is a high level overview for quick reference though.

### Output directory

If you want to store the compiled documentation pages in a different directory than the default 'docs' directory,
for example to specify a version like the Hyde docs does, you can specify the output directory in the Docs configuration file.

```php
'output_directory' => 'docs' // default
'output_directory' => 'docs/master' // What the Hyde docs use
```

### Sidebar header name

By default, the site title shown in the sidebar header is generated from the configured site name suffixed with "docs".
You can change this in the Docs configuration file.

```php
'title' => 'API Documentation',
```

### Sidebar page order

To quickly arrange the order of items in the sidebar, you can reorder the page slugs in the list and the links will be sorted in that order.
Link items without an entry here will have fall back to the default priority of 999, putting them last.

```php
'sidebar_order' => [
    'readme',
    'installation',
    'getting-started',
]
```

See [the chapter in the customization page](customization.html#navigation-menu--sidebar) for more details. <br>


### Table of contents settings

In the `config/docs.php` file you can configure the behavior, content,
and the look and feel of the sidebar table of contents.
You can also disable the feature completely.

```php
'table_of_contents' => [
	'enabled' => true,
	'min_heading_level' => 2,
	'max_heading_level' => 4,
	'smooth_page_scrolling' => true,
],
```

### Search feature

The HydeSearch plugin was introduced in v0.29.0-beta and adds a search feature to documentation pages.

The search feature is enabled by default.
You can disable it by removing the `documentationSearch` from the Hyde `Features` config array.

The search works by generating a JSON search index which the JavaScript plugin loads asynchronously.

Two types of search methods are added, one is a full page search screen that will saved to `docs/search.html`.
<small><blockquote>The full page can be disabled by setting `create_search_page` to `false` in the `docs` config.</blockquote></small>

The second method is a button added to the documentation pages, similar to how Algolia DocSearch works.
Opening it will open a dialog modal with an integrated search screen.
You can also open the dialog using the keyboard shortcut `/`.

### Automatic "Edit Page" button

#### Introduction

Added in v0.31, Hyde can automatically add links to documentation pages that takes the user
to a GitHub page (or similar) to edit the page. This makes it great for open-source projects
looking to allow others to contribute to the documentation in a quick and easy manner.

The feature is automatically enabled when you specify a base URL in the Docs configuration file.
Hyde expects this to be a GitHub path, but it will probably work with other methods as well,
if not, please send a PR and/or create an issue on the [GitHub repository](https://github.com/hydephp/framework)!

#### Example configuration

Let's take a practical example for how HydePHP.com uses this feature.

```php
// Filepath: config/docs.php

'source_file_location_base' => 'https://github.com/hydephp/docs/blob/master/',
```

#### Changing the button text

Changing the label is easy, just change the following config setting:

```php
// Filepath: config/docs.php
'edit_source_link_text' => 'Edit Source on GitHub',
```

#### Changing the position

By default the button will be shown in both the documentation page footer.
You can change this by setting the following config setting to `'header'`, `'footer'`, or `'both'`

```php
// Filepath: config/docs.php
'edit_source_link_position' => 'header',
```

#### Adding a button icon

This is not included out of the box, but is easy to add with some CSS!
Just target the `.edit-page-link` class.

```css
// filepath e.g. app.css
.edit-page-link::before {content: "✏ "}
```