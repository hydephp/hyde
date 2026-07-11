# HydePHP v3.0 Upgrade Guide

## Overview

//

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

## Step 2: Review the BladeDown Default

HydePHP v3 enables BladeDown (Blade in Markdown) by default. New projects and projects without an explicit
`markdown.enable_blade` setting will render `[Blade]:` directives and can execute PHP from them during a build.

Existing projects normally keep their published `config/markdown.php` file during a dependency update. If yours
currently sets `enable_blade` to `false`, it will remain disabled until you change it:

```php
// filepath: config/markdown.php
'enable_blade' => true,
```

The v3 default is intended for sites where Markdown is part of the trusted, reviewed project source. If you ingest
Markdown from users or another untrusted source, or your CI builds pull requests before review, keep the setting
disabled:

```php
// filepath: config/markdown.php
'enable_blade' => false,
```

BladeDown is not a security boundary for contributors who can add arbitrary project files, since they could add a
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

## Migration Checklist

Use this checklist to track your upgrade progress:

- [ ] Reviewed `markdown.enable_blade` and explicitly selected the appropriate trust policy
- [ ] Replaced any `php hyde rebuild <path>` usage with `StaticPageBuilder::handle()` or a full `php hyde build`

## Troubleshooting


## Getting Help

If you encounter issues during the upgrade:

- **Documentation**: [https://hydephp.com/docs/3.x](https://hydephp.com/docs/3.x)
- **GitHub Issues**: [https://github.com/hydephp/hyde/issues](https://github.com/hydephp/hyde/issues)
- **Community Discord**: [https://discord.hydephp.com](https://discord.hydephp.com)

For the complete changelog with all pull request references, see the [full release notes](https://github.com/hydephp/hyde/releases/tag/v3.0.0).
