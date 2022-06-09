---
label: "Creating Blog Posts"
priority: 11
category: "Creating Content"
---

# Creating Blog Posts

## Introduction to Hyde Posts

Making blog posts with Hyde is easy. At the most basic level,
all you need is to add a Markdown file to your `_posts` folder.

To use the full power of the Hyde post module however,
you'll want to add YAML Front Matter to your posts.

You can scaffold posts with automatic front matter using the HydeCLI:
```bash
php hyde make:post
```
Learn more about scaffolding posts, and other files, in the [console commands](console-commands.html) documentation.


## Short Video Tutorial

<iframe width="560" height="315" src="https://www.youtube-nocookie.com/embed/gjpE1U527h8" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>

## Best Practices and Hyde Expectations

Since Hyde does a lot of things automatically, there are some things you may need
to keep in mind when creating blog posts so that you don't get unexpected results.

### Filenames

- Markdown post files are stored in the `_posts` directory
- The filename is used as the filename for the compiled HTML
- Filenames should use `kebab-case-slug` followed by the extension `.md`
- Files prefixed with `_underscores` are ignored by Hyde
- Your post will be stored in `_site/posts/<slug>.html`

**Example:**
```bash
✔ _posts/hello-world.md # Valid and will be compiled to _site/posts/hello-world.html
```

### Front Matter

Front matter is optional, but highly recommended for blog posts.

You can read more about the Front Matter format in the [Front Matter documentation](architecture-concepts.html#front-matter).
Here is a quick primer:

- Front matter is stored in a block of YAML that starts and ends with a `---` line.
- The front matter should be the very first thing in the Markdown file.
- Each key-pair value should be on its own line.
- The front matter is used to construct dynamic HTML markup for the post as well as meta tags and post feeds.
  You are encouraged to look at the compiled HTML to learn and understand how your front matter is used.


**Example:**
```markdown
---
title: "My New Post"
---

## Markdown comes here
```

You can use the `php hyde make:post` command to automatically generate the front matter based on your input.


## A first look at Front Matter

Before digging in deeper on all the supported front matter options,
let's take a look at what a basic post with front matter looks like.

This file was created using the `make:post` by hitting the `Enter` key to use
all the defaults (with some extra lorem ipsum to illustrate).

```markdown {: filepath="_posts/my-new-post.md"}
---
title: My New Post
description: A short description used in previews and SEO
category: blog
author: Mr. Hyde
date: 2022-05-09 18:38
---

## Write your Markdown here

Lorem ipsum dolor sit amet, consectetur adipisicing elit.
Autem aliquid alias explicabo consequatur similique,
animi distinctio earum ducimus minus, magnam.
```

### How the Front Matter is used

The front matter is used to construct dynamic HTML markup for the post as well as meta tags and post feeds.

You are encouraged to look at the compiled HTML to learn and understand how your front matter is used.

### Front matter syntax

Here is a quick reference of the syntax Hyde uses and expects:

```markdown
---
key: value
string: "quoted string"
boolean: true
integer: 100
array:
  key: value
  key: value
---
```

## Supported Front Matter properties

### Post Front Matter Schema

Here is a quick reference of the supported front matter properties.
Keep on reading to see further explanations, details, and examples. 


| **KEY NAME**   | **VALUE TYPE** | **EXAMPLE / FORMAT**             |
|----------------|----------------|----------------------------------|
| `title`        | string         | "My New Post"                    |
| `description`  | string         | "A short description"            |
| `category`     | string         | "my favorite recipes"            |
| `date`         | string         | "YYYY-MM-DD [HH:MM]"             |
| `author`       | string/array   | _See [author](#author) section_  |
| `image`        | string/array   | _See [image](#image) section_    |


Note that YAML here is pretty forgiving. In most cases you do not need to wrap strings
in quotes, but it can help in certain edge cases, thus they are included here.

In the examples below, when there are multiple keys, they signify various ways to use the parameter.

### Title

```yaml
title: "My New Post"
```


### Description

```yaml
description: "A short description used in previews and SEO"
```


### Category

```yaml
category: blog
category: "My favorite recipes"
```


### Date

```yaml
date: "2022-01-01 12:00" 
date: "2022-01-01" 
```


### Author

```yaml
author: "Mr. Hyde" # Arbitrary name displayed "as is"
author: mr_hyde # Username defined in `authors` config
author: # Array of author data
  name: "Mr. Hyde" 
  username: mr_hyde 
  website: https://twitter.com/hyde_php
```

When specifying an array you don't need all the sub-properties.
The example just shows all the supported values. Array values here
will override all the values in the `authors` config entry.

### Image

```yaml
image: image.jpg # Expanded by Hyde to `_media/image.jpg` and is resolved automatically
image: https://cdn.example.com/image.jpg # Full URL starting with `http(s)://`)
image:
  path: image.jpg
  uri: https://cdn.example.com/image.jpg # Takes precedence over `path`
  description: "Alt text for image"
  title: "Tooltip title"
  copyright: "Copyright (c) 2022"
  license: "CC-BY-SA-4.0"
  licenseUrl: https://example.com/license/
  credit: https://photographer.example.com/
  author: "John Doe"
```

When supplying an image with a local image path, the image is expected to be stored in the `_media/` directory.

The image will be used as the cover image, and any array data is constructed into a dynamic fluent caption,
and injected into post and page metadata.

> See [posts/introducing-images](https://hydephp.com/posts/introducing-images.html)
> for a detailed blog post with examples and schema information!
{ .info }


## Using images in posts

To use images stored in the `_media/` directory, you can use the following syntax:

```markdown
![Image Alt](../media/image.png "Image Title") # Note the relative path
```

To learn more, check out the [chapter in managing assets](managing-assets.html#managing-images)