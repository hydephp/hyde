# About the _pages directory

In this directory you can place markdown files that will be transformed into simple static HTML pages.
Perfect for about pages that don't need much extra styling!

Currently, only top level pages are supported. The filename of the generated file is based on the markdown filename.
For example, `_pages/custom-page.md` gets saved as `_site\custom-page.html`.

## Creating pages

When making pages you should use Front Matter blocks to define the metadata such as the title.

Currently, only the `title` property is supported.

### Example
```blade
---
title: "My Page Title"
---

Hello World!
```
