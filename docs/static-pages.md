---
priority: 11
label: "Markdown & Blade Pages"
category: "Creating Content"
---

# Creating Static Pages

## Introduction to Hyde Pages

Hyde offers two ways to create static pages:
**Markdown pages** which are perfect for simple pages that focuses heavily on the content,
and **Blade pages** which are perfect for more complex pages where you want full control over the HTML,
and where you may want to include other components.

Let's start with the basics.

### Best Practices and Hyde Expectations

Since Hyde does a lot of things automatically, there are some things you may need
to keep in mind when creating blog posts so that you don't get unexpected results.

#### Filenames

- Hyde Pages are files are stored in the `_pages` directory
- The filename is used as the filename for the compiled HTML
- Filenames should use `kebab-case-slug` format, followed by the appropriate extension
- Files prefixed with `_underscores` are ignored by Hyde
- Your page will be stored in `_site/<slug>.html`
- Blade pages will override any Markdown pages with the same filename when compiled

## Creating Markdown Pages

Markdown pages are the easiest way to create static pages, and are similar to [blog posts](blog-posts.html).
You may want to read that page first as it explains [how front matter works](blog-posts.html#supported-front-matter-properties)
and how to use it.

You can create a Markdown page by adding a file to the `_pages` directory where the filename ends in `.md`.

### Scaffolding Markdown Pages
Scaffolding a Markdown page is as easy as using the [HydeCLI](console-commands.html).

```bash
php hyde make:page "Page Title"
```

This will create the following file saved as `_pages/page-title.md`

```markdown
---
title: Page Title
---

# Page Title

// Write your content here
```

You can of course also create the file yourself with your text editor.

### Front Matter is optional

The only front matter supported is the title, which is used as the HTML `<title>`.

If you don't supply a front matter title, Hyde will attempt to find a title in the Markdown body by searching
for the first level one heading (`# Page Title`), and if that fails, it will generate one from the filename.

In the future, more front matter options such as page descriptions and meta tags will be supported.


## Creating Blade Pages

Since Hyde is based on Laravel and uses the Blade templating engine,
you can use Blade pages to create more complex pages.

If you are not familiar with Blade, you may want to read [the Laravel Blade docs](https://laravel.com/docs/9.x/blade) first.


### Scaffolding Blade Pages
We can scaffold Blade pages using the same CLI command as Markdown pages, however,
this time we need to specify that we want to use the `blade` page type.

```bash
php hyde make:page "Page Title" --type="blade"
```

This will create a file saved as `_pages/page-title.blade.php`

You can of course also create the file yourself with your text editor, however,
the scaffolding command for Blade pages is arguably even more helpful than the
one for Markdown pages, as this one automatically adds the included app Layout.

Let's take a look at the scaffolded file. You can also copy and paste this
if you don't want to use the scaffolding command.

```blade
@extends('hyde::layouts.app')
@section('content')
@php($title = "Page Title")

<main class="mx-auto max-w-7xl py-16 px-8">
	<h1 class="text-center text-3xl font-bold">Page Title</h1>
</main>

@endsection
```

> Tip: You don't have to use Blade in Blade pages. It's also perfectly fine to use plain HTML,
> however you still need to use the `blade.php` extension so Hyde can recognize it.


## When to use which?

Markdown pages look great and work well for simple "about" pages and the like, but with Markdown we are still pretty limited. 

If you are comfortable with it, and have the need for it, use Blade to create more complex pages! And mix and match between them! Some page types are better suited for Markdown, and others for Blade.

### Comparison

| Markdown                                            | Blade                                                                                    |
|-----------------------------------------------------|------------------------------------------------------------------------------------------|
| ➕ Easily created and updated                        | ➕ Full control over the HTML                                                             |
| ➕ Very fast to create simple and lightweight pages  | ➕ Use the default app layout or create your own                                          |
| ➕ Suited for content heavy pages such as "about us" | ➕ Use Blade templates and components to keep code DRY                                    |
| ➖ Not as flexible as Blade pages                    | ➕ Use arbitrary PHP right in the page to create dynamic content                          |
|                                                     | ➕ Access to all Blade helper directives like @foreach, @if, etc.                         |
|                                                     | ➖ Takes longer to create as as you need to write the markup                              |
|                                                     | ➖ You may need to [recompile your CSS](managing-assets.html) if you add Tailwind classes |


### Live Demos

The Hyde website ([hydephp.com](https://hydephp.com/)) uses both Markdown and Blade pages.

The "Privacy" which you can find at [hydephp.com/privacy](https://hydephp.com/privacy) is a Markdown page,
which is a perfect fit for this task, where the goal was to simply inform about the privacy policy.

The "Gallery" which you can find at [hydephp.com/gallery](https://hydephp.com/gallery) is a Blade page.
While a photo gallery could be used in a Markdown page, here I opted to use a Blade page instead. This allowed me
to create a bunch of cool and dynamic interactions and animations as I had full control over the HTML and could
easily add scripts, styles, and iframes. I also seperated sections into components to make them easier to manage.
