# HydePHP v3.0 Upgrade Guide

## Overview

HydePHP v3 infers an `InMemoryPage` output extension from its identifier. Identifiers that already have an extension keep
it, while identifiers without an extension compile to `.html`:

```php
use Hyde\Pages\InMemoryPage;

InMemoryPage::make('about', contents: $html);
// _site/about.html

InMemoryPage::make('robots.txt', contents: $text);
// _site/robots.txt
```

## Before You Begin

### Prerequisites

//

### Backup Your Project

Before starting the upgrade process, it's **strongly recommended** to:

- **Commit all changes to Git** - This allows you to easily revert if needed
- **Create a backup** of your entire project directory
- **Have a previous site build** so you can compare output

If you're not already using Git for version control, now is an excellent time to initialize a repository:

```bash
git init
git add .
git commit -m "Pre-upgrade backup before HydePHP v3.0"
```

### Estimated Time

//

## Step 1: Update Dependencies

### Update Composer Dependencies

//

### Update Node Dependencies

HydePHP v3 upgrades the bundled `vite` dependency from v7 to v8. Update your `package.json` `devDependencies` to require the new major version:

```json
{
    "devDependencies": {
        "vite": "^8.0.0"
    }
}
```

Then run `npm install` (or your package manager's equivalent) to pick up the update.

If you have a custom `vite.config.js` that overrides `build.rollupOptions`, note that Vite 8 builds with Rolldown by default. The `hyde-vite-plugin` now configures its own build options under `build.rolldownOptions` rather than `build.rollupOptions` — if your custom config only sets `rollupOptions`, double check your output still ends up where you expect after upgrading.

## Step 2: Review the Markdown Trust Defaults

HydePHP v3 enables both raw HTML and Blade in Markdown by default. The existing `markdown.enable_blade` setting controls both
`[Blade]:` directives and the new executable `blade render` and `blade component="name"` fenced code blocks. New
projects and projects without explicit settings can render arbitrary HTML and execute PHP during a build.

Existing projects normally keep their published `config/markdown.php` file during a dependency update. If yours
currently sets either option to `false`, that behavior remains disabled until you change it:

```php
// filepath: config/markdown.php
'allow_html' => true,
'enable_blade' => true,
```

When enabled, the following fences are executable. A fence using only `blade` remains an ordinary syntax-highlighted
code sample.

- `blade render`
- `blade component="name"`

The v3 defaults are intended for sites where Markdown is part of the trusted, reviewed project source. If you ingest
Markdown from users or another untrusted source, or your CI builds pull requests before review, disable raw HTML and
Blade in Markdown:

```php
// filepath: config/markdown.php
'allow_html' => false,
'enable_blade' => false,
```

These settings are not a security boundary for contributors who can add arbitrary project files, since they could add a
malicious `.blade.php` file instead. Review source changes before building them in a privileged environment.

## Step 3: Replace the Removed `rebuild` Command

The `rebuild` command has been removed in v3.0. It had no remaining internal consumers now that the realtime compiler renders pages entirely in-memory, and building a single page could silently leave aggregate outputs (sitemap, RSS, search index, navigation) stale while looking like a complete build.

**Before:**
```bash
php hyde rebuild _posts/hello-world.md
```

**After:**

If you need to build a single page programmatically, use `StaticPageBuilder::handle()` directly:

```php
use Hyde\Foundation\Facades\Pages;
use Hyde\Framework\Actions\StaticPageBuilder;

StaticPageBuilder::handle(Pages::getPage('_posts/hello-world.md'));
```

Note that this only produces a correct `_site` when the page is self-contained. For anything that touches aggregate outputs, run `php hyde build` to rebuild the whole site instead.

## Optional: Adopt Versioned Documentation

HydePHP v3 adds native support for hosting multiple versions of your documentation side by side. This feature is entirely opt-in — if you do nothing, your documentation site works exactly as before.

To enable it:

1. Move your documentation source files into version subdirectories, for example `_docs/1.x/` and `_docs/2.x/`.
2. Register the versions in `config/docs.php`:

```php
// filepath: config/docs.php
'versions' => [
    '1.x',
    '2.x',
],
```

Each version is compiled to a matching subdirectory of the documentation output directory (`docs/1.x`, `docs/2.x`), with its own sidebar, search index, and search page. A version switcher is shown in the sidebar, and `docs/index.html` is generated as a redirect to the default version's index page (the last entry in the list, or set `docs.default_version` explicitly).

Versioning is all or nothing: once you register versions, every documentation page must live in a version directory. Make sure step 1 is complete, as any Markdown files left directly in `_docs` are ignored, and will no longer be compiled. Each ignored file is reported as a build warning, so if you miss one, `php hyde build` tells you which:

```
Ignoring unversioned documentation file "_docs/installation.md" as documentation versioning is enabled. Move it into a registered version directory to include it in the site.
```

If you want a page at the documentation root, create it in your normal page source directory instead, for example `_pages/docs/index.md`, which then replaces the generated redirect.

Your existing `docs.sidebar.order`, `docs.sidebar.labels`, `docs.sidebar.exclude`, and `docs.exclude_from_search` entries keep working without version prefixes — they apply to the matching page in every version. Prefix an entry with a version (like `2.x/readme` or `docs/2.x/readme`) to target a single version.

If you previously implemented multi-version documentation with custom page classes or extensions (like early versions of HydePHP.com did), you can now remove that custom code in favor of the `docs.versions` configuration, keeping your existing `_docs/<version>` directory layout as-is.

## Step 4: Move Redirects Into Configuration

Redirects are now part of the normal site build and must be declared in `config/hyde.php`. The `Redirect::create()` and
`Redirect::store()` methods have been removed because they wrote directly to the output directory outside the kernel's
build graph.

**Before:**

```php
use Hyde\Support\Models\Redirect;

Redirect::create('old-page', 'new-page');
```

**After:**

```php
// filepath: config/hyde.php
'redirects' => [
    'old-page' => 'new-page',
],
```

Configured redirects are included in `route:list` and generated by `php hyde build`. They are automatically excluded
from navigation menus and the sitemap. Redirect pages always include a visible fallback link, so the previous
`showText` constructor argument is no longer available.

## Step 5: Migrate `InMemoryPage` Instance Macros

HydePHP v3 removes the `InMemoryPage` instance macro API. Since v3 is a major release, lazy closure contents directly
replace the common dynamic-content use case without carrying a transitional API.

Move callbacks previously registered as `compile` macros into the constructor or `InMemoryPage::make()` contents argument.

**Before:**

```php
$page = new InMemoryPage(
    'sitemap.xml',
    ['navigation' => ['hidden' => true]],
);

$page->macro(
    'compile',
    fn (): string => app(SitemapGenerator::class)->generate()->getXml(),
);
```

**After:**

```php
$page = new InMemoryPage(
    'sitemap.xml',
    contents: fn (): string => app(SitemapGenerator::class)->generate()->getXml(),
);
```

Content closures are invoked lazily during compilation, are not cached, and are never rebound to the page instance. Hyde instead passes the current page as the closure’s first argument, which may be omitted when page context is unnecessary. When migrating a previous bound compile macro that used $this to access page state, accept the page through this parameter instead. This preserves page context without altering the closure’s existing object binding, which PHP does not support for all closure types.

**Before:**

```php
$page = new InMemoryPage('example');

$page->macro('compile', function (): string {
    return $this->getIdentifier();
});
```

**After:**

```php
$page = new InMemoryPage(
    'example',
    contents: function (InMemoryPage $page): string {
        return $page->getIdentifier();
    },
);
```

For macros other than `compile`, create an `InMemoryPage` subclass and add the method normally.

**Before:**

```php
$page = new InMemoryPage('report');
$page->macro('reportTitle', fn (): string => 'Monthly Report');
```

**After:**

```php
class ReportPage extends InMemoryPage
{
    public function reportTitle(): string
    {
        return 'Monthly Report';
    }
}

$page = new ReportPage('report');
```

### Select One `InMemoryPage` Content Source

`InMemoryPage` no longer gives configured contents precedence over a configured Blade view. The `contents` and `view`
arguments are now mutually exclusive, and the constructor throws an `InvalidArgumentException` when both are supplied.
Calls already using only `contents:` or only `view:` do not need to change.

If an existing call supplies a PHP-truthy contents value and a view, remove the ignored view to preserve the previous
behavior:

```php
// Before
new InMemoryPage('example', contents: '<h1>Example</h1>', view: 'pages.example');

// After
new InMemoryPage('example', contents: '<h1>Example</h1>');
```

Previously, contents equal to `''` or `'0'` were treated as omitted, so the view rendered instead. To preserve that
behavior, remove the contents argument or replace it with `null`:

```php
// Before: the view rendered because '0' was treated as omitted
new InMemoryPage('example', contents: '0', view: 'pages.example');

// After
new InMemoryPage('example', view: 'pages.example');
```

The parameter order is unchanged, but `null` now represents an omitted content source. Replace the old empty-string
placeholder in positional view calls with `null`, or preferably use the named `view` argument:

```php
// Before
new InMemoryPage('example', [], '', 'pages.example');

// After: minimal positional migration
new InMemoryPage('example', [], null, 'pages.example');

// After: recommended
new InMemoryPage('example', view: 'pages.example');
```

An explicitly empty literal remains valid as long as no view is also supplied:

```php
new InMemoryPage('empty', contents: '');
```

An empty view string is treated as an omitted view, so existing calls that pass `view: ''` continue to create a
content-only or empty page. Prefer omitting the argument or passing `null` when no view is intended:

```php
// Valid, but redundant
new InMemoryPage('example', view: '');

// Recommended
new InMemoryPage('example', view: null);
```

## Step 6: Review Non-HTML Navigation Visibility

Non-HTML pages are excluded from automatic navigation by default. If you want one to appear, add
`navigation.visible: true` or `navigation.hidden: false` to its front matter.

Explicit navigation front matter now overrides Hyde's automatic exclusions. Review `navigation.visible: true` and
`navigation.hidden: false` on blog posts, routes listed in `hyde.navigation.exclude`, and pages in hidden subdirectories,
as those settings were previously ignored.

## Step 7: Review Sitemap and RSS Feed Customizations

Sites that only use the built-in sitemap and RSS configuration need no changes. The `GenerateSitemap` and `GenerateRssFeed`
post-build task classes have been removed, so update code that referenced or overrode them.

Replace a custom sitemap task with a `SitemapGenerator` implementation bound in the `register()` method of a service
provider. Replace a custom RSS task with a bound `RssFeedGenerator` implementation. The framework registers the
generated pages; the generator bindings control their contents.

The `build:sitemap` and `build:rss` commands still work, but now fail when their corresponding page is not registered.

## Step 8: Rename Page File Extension References

The static page class property `$fileExtension` has been renamed to `$sourceExtension`, along with the
`fileExtension()` and `setFileExtension()` methods, which are now `sourceExtension()` and `setSourceExtension()`.
The new name makes it explicit that these APIs describe the extension of source files.

This only affects projects with custom page classes or code calling these APIs. Update property declarations,
call sites, and any methods that override `fileExtension()` or `setFileExtension()` — the methods are public
and non-final, and an un-renamed override silently stops being called now that the framework calls
`sourceExtension()`:

**Before:**

```php
class CustomPage extends HydePage
{
    public static string $fileExtension = '.md';
}

$extension = MarkdownPage::fileExtension();
```

**After:**

```php
class CustomPage extends HydePage
{
    public static string $sourceExtension = '.md';
}

$extension = MarkdownPage::sourceExtension();
```

The automated upgrade script will handle this rename for ordinary property declarations, property accesses,
method calls, and overridden method declarations. Dynamic references — variable method or property names,
reflection, and string-based access — must be updated manually.

## Step 9: Replace Your Code Block Filepath Comments

Code block labels are now set with a `title="…"` modifier on the fence, and the `// filepath:` comment is no longer
recognized. A comment left behind stays in the code as written, where it renders as an ordinary first line.

A block written like this:

````markdown
```php
// filepath: app/Models/Post.php
echo 'Hello World!';
```
````

Becomes:

````markdown
```php title="app/Models/Post.php"
echo 'Hello World!';
```
````

Search your source files for `filepath` to find the blocks to convert. All the documented comment forms are affected,
so also check for `#`, `/* */`, and `<!-- -->` comments. A blank line left between the old comment and the code can be
removed with it.

HydePHP v3 displays code block labels in a responsive header instead of the v2 top-right badge.

## Step 10: Move Your Filepath Label Customizations

Fenced code blocks are now rendered through the `components/markdown/code-block.blade.php` view, which also holds the
label markup. The `components/filepath-label.blade.php` view is gone.

If you never published the label view, there is nothing to do here.

If you did publish and customize it, your copy is no longer used, and your site renders with Hyde's default label
until you move your changes over. Publish the code block view, choosing it individually so your other published views
are left alone, then re-apply your changes and delete the old file:

```bash
php hyde publish:views
```

Do not pass the group name, as in `php hyde publish:views components`, since that publishes the whole group and
overwrites every component view you have already customized.

The markup around code blocks has also changed, so compare a few pages against your old site if you have custom CSS
for them. The `hyde-code-block` and `hyde-code-block-label` classes are stable hooks you can target instead of
matching the markup structure. Syntax highlighting is unaffected.

## Step 11: Review Drafts and Future-Dated Blog Posts

HydePHP v3 keeps two kinds of blog post out of your built site: those marked `draft: true` in front matter, and those whose date is set in the future. Drafts and scheduled posts are skipped during auto-discovery, so they get no route, are not compiled to `_site`, and are left out of post listings, the sitemap, and the RSS feed. The date rule applies to both front matter dates and filename date prefixes.

Drafts and scheduled posts are still included by `php hyde serve`, which is treated as an authoring preview, so you can keep writing and previewing them at their normal URL.

In v2 both kinds of post were built like any other. Hyde assigned no built-in publication behavior to `draft`, although custom templates or extensions may already have read the property. In v3, `draft: true` excludes the post from site builds. So if your site has posts dated ahead of the build time, or posts already carrying a `draft: true` annotation, they will disappear from your site after upgrading.

To find affected posts, search `_posts` for `draft: true`, and check for dates ahead of the build time in both front matter and filename prefixes. If a post disappears after upgrading but remains visible through `php hyde serve`, one of these two states is the reason.

If a post that was supposed to be published turns out to be excluded, remove the `draft` property or correct the date. If you actually want to schedule posts, remember that **Hyde is a static site generator**: a scheduled post does not publish itself when its date passes. It is included in the first site build that runs after that point, so you need recurring builds for a post to go live on its own, for example a cron-scheduled GitHub Actions workflow.

## Step 12: Move Manually Maintained Output Files Into `_static`

HydePHP v3 empties the entire output directory before every build. In v2 the build only removed HTML and JSON files along with the media directory, so anything else you put in `_site` stayed there between builds. Files like `CNAME`, `.nojekyll`, and search engine verification files were commonly committed straight into the output directory for that reason.

Move those files into the `_static` directory, which is copied verbatim to the site root on every build, so `_static/CNAME` becomes `_site/CNAME`.

The `hyde.safe_output_directories` option no longer exists, and the build no longer asks for confirmation before emptying an unfamiliar output directory. Delete the entry from your `config/hyde.php`. Take the chance to double-check your `hyde.output_directory` if you build somewhere other than `_site`, since everything in that directory is now removed on every build.

## Migration Checklist

Use this checklist to track your upgrade progress:

- [ ] Reviewed `markdown.allow_html` and `markdown.enable_blade` and explicitly selected the appropriate trust policy
- [ ] Replaced any `php hyde rebuild <path>` usage with `StaticPageBuilder::handle()` or a full `php hyde build`
- [ ] Moved calls to `Redirect::create()` or `Redirect::store()` into the `hyde.redirects` configuration array
- [ ] Moved `InMemoryPage` `compile` macro callbacks into the contents argument and replaced other macros with subclass methods
- [ ] Updated `InMemoryPage` calls to supply only one of `contents` and `view`
- [ ] Explicitly opted in any non-HTML pages that should remain in automatic navigation
- [ ] Replaced any references to the removed `GenerateSitemap` and `GenerateRssFeed` build tasks with generator implementations bound in a service provider
- [ ] Renamed `$fileExtension`, `fileExtension()`, and `setFileExtension()` to `$sourceExtension`, `sourceExtension()`, and `setSourceExtension()` in custom page classes and call sites
- [ ] Replaced `// filepath:` code block comments with the `title="…"` fence modifier
- [ ] Ported any `filepath-label.blade.php` customizations to `markdown/code-block.blade.php`, and deleted the old file
- [ ] Compared pages against your old site if you have custom CSS for code blocks or their labels
- [ ] Checked `_posts` for drafts and blog posts dated in the future, and set up recurring builds if scheduling posts
- [ ] Moved manually maintained files out of the output directory and into `_static`

## Troubleshooting


## Getting Help

If you encounter issues during the upgrade:

- **Documentation**: [https://hydephp.com/docs/3.x](https://hydephp.com/docs/3.x)
- **GitHub Issues**: [https://github.com/hydephp/hyde/issues](https://github.com/hydephp/hyde/issues)
- **Community Discord**: [https://discord.hydephp.com](https://discord.hydephp.com)

For the complete changelog with all pull request references, see the [full release notes](https://github.com/hydephp/hyde/releases/tag/v3.0.0).
