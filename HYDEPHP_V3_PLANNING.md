# Welcome to the HydePHP v3 planning document!

Having this document in code lets us know the devlopment state at any given point in the development tree.

## Planned features

- Change all HydePHP reposotiries to use `main` instead of `master` as the default branch. This change will be executed around the time of the release.

## Checklist before release:

- Publish new major version of the Vite plugin (due to Vite 8 upgrade) then revert the monorepo loading the local file https://github.com/hydephp/develop/pull/2414/changes/42e745675c0eec12b42376dcb445f592bbd0d650

## Changes requires to this branch

## Changes required to the v2 branch

---

## Release Notes

### New Features

### Feature Changes

- BladeDown (Blade in Markdown) is now enabled by default. Hyde sites generally treat project content as trusted and reviewed; sites that compile untrusted or unreviewed Markdown can disable it with `markdown.enable_blade`.

### Minor Changes and Cleanup

- Removed the legacy `checkForDeprecatedRunMixCommandUsage` check and the placeholder `--run-dev`/`--run-prod` options from the `build` command, which were kept in v2 only to surface a helpful error message. ([#2461](https://github.com/hydephp/develop/pull/2461))
- Removed the deprecated `hyde.server.dashboard` boolean config check from `DashboardController::enabled()`, which was kept in v2 for backwards compatibility but had since then been replaced with `hyde.server.dashboard.enabled`. ([#2461](https://github.com/hydephp/develop/pull/2462))
- Upgraded the bundled `vite` dependency from v7 to v8, and widened the `hyde-vite-plugin`'s `vite` peer dependency range from `>=6.3.5 <8.0.0` to `>=6.3.5 <9.0.0` so downstream projects can adopt Vite 8 without waiting for a new plugin major. The plugin's build config now targets Vite 8's Rolldown-based bundler (`rolldownOptions` instead of `rollupOptions`). ([#2414](https://github.com/hydephp/develop/pull/2414))

### Breaking Changes

- Removed the `rebuild` command (`RebuildPageCommand`). It was originally added to build a single file to disk before the realtime compiler existed, and later used internally by the RC to build-and-serve a path, but the RC now renders everything in-memory, leaving `rebuild` with no remaining consumer. It also had no safe user-facing use case: a single-page build only produces a correct `_site` when the page is self-contained, while a page change routinely invalidates aggregate outputs (sitemap, RSS, search index, post listings, navigation), so single-path building could silently leave a stale output directory that looked complete. The underlying single-page build capability remains available internally via the `StaticPageBuilder` action. ([#2490](https://github.com/hydephp/develop/pull/2490))

### Upgrade guide

Please fill in UPGRADE.md as you make changes.

- BladeDown is now enabled by default. Existing projects with a published `config/markdown.php` retain their current setting; set `markdown.enable_blade` to `true` to adopt the v3 default, or keep it `false` when compiling untrusted or unreviewed Markdown.
- The `rebuild` command has been removed. If you need to build a single page programmatically, use `Hyde\Framework\Actions\StaticPageBuilder::handle()` instead.
