# Welcome to the HydePHP v3 planning document!

Having this document in code lets us know the devlopment state at any given point in the development tree.

## Planned features

- Change all HydePHP reposotiries to use `main` instead of `master` as the default branch. This change will be executed around the time of the release.
- Ship an upgrade script that migrates v2 source files to the v3 syntax. It needs to convert code block `// filepath:` comments to the `title="…"` fence modifier, following the rules in [Dropping the filepath comment syntax](#dropping-the-filepath-comment-syntax). The upgrade guide currently describes that conversion as a manual step, and should point at the script once it exists.

## Checklist before release:

- Publish new major version of the Vite plugin (due to Vite 8 upgrade) then revert the monorepo loading the local file https://github.com/hydephp/develop/pull/2414/changes/42e745675c0eec12b42376dcb445f592bbd0d650

## Changes requires to this branch

## Changes required to the v2 branch

---

## Release Notes

### New Features

- Added native support for versioned documentation pages. Register versions in the new `docs.versions` configuration option, and store the pages for each version in a matching subdirectory of the documentation source directory (like `_docs/1.x` and `_docs/2.x`). Each version is compiled to a matching subdirectory of the documentation output directory, and gets its own sidebar, search index, and search page. A version switcher dropdown is shown in the documentation sidebar, the main navigation links to the default version's index page, and a redirect page is generated at the documentation root pointing to the default version. Sidebar and search configuration entries (`docs.sidebar.order`, `docs.sidebar.labels`, `docs.sidebar.exclude`, and `docs.exclude_from_search`) match version-agnostic identifiers and route keys, so a single entry applies to the page in every version, while full versioned keys allow version-specific overrides. Enabling the feature is all or nothing: documentation source files stored outside the version directories are ignored, so pages that should live at the documentation root belong in the normal page source directory (like `_pages/docs/index.md`). Versioning is disabled by default, and single-version sites are unaffected. ([#2516](https://github.com/hydephp/develop/pull/2516))
- Redirects can now be declared as source and destination path pairs in the `hyde.redirects` configuration array. Hyde registers them with the kernel, includes them in `route:list`, and generates them through the normal site build.
- Added Blade Blocks for rendering Blade and Blade components from fenced code blocks in Markdown pages. The supported directives are `blade render` and `blade component="name"`, and the feature is controlled by `markdown.enable_blade`. ([#2504](https://github.com/hydephp/develop/pull/2504))
- Added built-in terminal code blocks using the `terminal` fence language. Command prompts are styled for selection-free copying, and terminal formatting tags are rendered as styled output: the named `<info>`, `<comment>`, `<question>`, and `<error>` styles, and colors and text formatting set with `fg`, `bg`, and `options` attributes, closed with `</>`. Unsupported syntax stays literal text, and a leading backslash escapes a tag. The window's title bar can be titled per block with `terminal title="Installing Hyde"`, which the terminal view receives as a `$title` variable, falling back to the `Terminal` label when a block sets no title. ([#2188](https://github.com/hydephp/develop/issues/2188), [#2485](https://github.com/hydephp/develop/issues/2485))
- Blog posts can now be kept out of the published site through two zero-configuration publication states. Setting `draft: true` in front matter excludes a post indefinitely, until the property is removed or set to `false`, which suits content that is unfinished or awaiting approval. Setting a date in the future schedules a post, excluding it until that date has passed. Drafts and scheduled posts are skipped during auto-discovery when building the site: they get no route, are not present in the kernel's page and route collections, and are left out of post listings, the sitemap, and the RSS feed. The date rule supports both front matter dates and filename date prefixes, and an explicit draft outranks the date, so a draft stays excluded even after its date passes. Posts are published by default, making `draft: false` a no-op. Both states remain served by the realtime compiler, which is treated as an authoring preview, so posts can be written and proofread at their normal URL without editing their front matter: `serve` shows everything you are working on, while `build` publishes only what is eligible. Since Hyde is a static site generator, a scheduled post does not publish itself once its date passes: it is included in the first site build run after that point, so recurring builds (for example a cron-scheduled GitHub Actions workflow) are needed for a post to go live on its own. The new `MarkdownPost::isDraft()` and `MarkdownPost::isScheduled()` methods expose the checks. ([#2441](https://github.com/hydephp/develop/issues/2441), [#2572](https://github.com/hydephp/develop/pull/2572))
- `InMemoryPage` now infers its output format from the identifier: identifiers with an extension keep it, while identifiers without one compile to `.html`. Only the HTML extension is implicit in route keys, so non-HTML paths such as `robots.txt` and `docs/search.json` remain route keys as-is. Subclasses can also declare `$outputDirectory` and `$outputExtension`, the same way a regular `HydePage` subclass does, to give all their instances a shared location and format; use extensionless identifiers with these subclasses so the configured extension applies.
- Pages with non-HTML output paths are excluded from automatic navigation by default, since files like `robots.txt` and `feed.xml` are not pages a visitor navigates to. Navigation front matter now always wins over the automatic behavior, so `navigation.visible: true` (or `navigation.hidden: false`) opts such a page back in, and it likewise adds the other pages Hyde leaves out on its own, like blog posts, route keys listed in `hyde.navigation.exclude`, and pages in hidden subdirectories, which stayed hidden regardless in v2.
- Pages can now control their own sitemap inclusion. Set `sitemap: false` in a page's front matter to exclude it from the generated `sitemap.xml`, or override the new `HydePage::showInSitemap()` method in custom page classes. Pages compiled to non-HTML output files (like `robots.txt`) are excluded by default, and `sitemap: true` front matter opts such a page back in.
- The sitemap and RSS feed are now first-class pages instead of post-build side effects: when the respective feature is enabled, `sitemap.xml` and the RSS feed (`feed.xml`, or the configured `hyde.rss.filename`) are registered as routes, so they are served by `hyde serve`, listed in `route:list`, included in the build manifest, and compiled through the standard site build. The output can be customized by binding a replacement `SitemapGenerator` or `RssFeedGenerator` in the service container.

### Feature Changes

- Fenced code blocks are now rendered through a publishable Blade view, `components/markdown/code-block.blade.php`, in the same way terminal blocks are. The view receives the rendered code block markup as `$contents`, along with `$language` and `$label`, and decides what goes around it, so changing what surrounds a code block is a view change instead of a framework change. Highlighting itself is unaffected: the fence stays in the syntax tree as the wrapper's child, and is rendered by whichever renderer the environment already had for it, be it Torchlight, a third-party extension, or CommonMark's own.
- Code block labels are now set with a `title="…"` modifier on the fence, using the same attribute syntax as terminal block titles, such as ` ```php title="app/Model.php" `. The language is optional, so ` ``` title=".env" ` labels a block that declares none, which is then treated as `plaintext`. The label is no longer tied to file paths, so a block can be titled with anything. The v2 `// filepath:` comment syntax is removed.
- Blade in Markdown is now enabled by default. The `markdown.enable_blade` option controls both `[Blade]:` directives and executable Blade Blocks. Hyde sites generally treat project content as trusted and reviewed; sites that compile untrusted or unreviewed Markdown can disable both forms with this option.
- Raw HTML in Markdown is now enabled by default. Hyde sites generally treat project content as trusted and reviewed; sites that compile untrusted or unreviewed Markdown can set `markdown.allow_html` to `false` to strip potentially unsafe HTML tags.
- `InMemoryPage` contents now accept lazy closures in addition to literal strings. Closures are invoked each time contents are requested with the current page as their first argument, without being rebound.
- `InMemoryPage` callers now select either literal/lazy `contents` or a Blade `view`. Supplying both throws an `InvalidArgumentException` instead of silently giving contents precedence.

### Minor Changes and Cleanup

- Fixed documentation search index files leaking into the generated sitemap: `search.json` (and any other page compiled to a non-HTML output file) no longer appears in `sitemap.xml`. The sitemap generator now asks each page through `HydePage::showInSitemap()` instead of only filtering out redirect pages.
- The `Redirect` page class constructor now accepts an optional `$matter` parameter, used by the framework to hide the generated documentation root redirect from navigation menus. Existing usages are unaffected.
- The realtime compiler now resolves registered page routes before proxying static assets, replacing the hardcoded `search.json` exemption, so `hyde serve` serves any registered route regardless of its output extension. Registered pages now always win over a static file at the same path; the previous behavior of serving such a shadowing file only affected the dev server and no real setups are expected to be affected.

- Removed `Hyde\Markdown\Processing\CodeblockFilepathProcessor`, along with the `<!-- HYDE[Filepath] -->` marker comments it passed between its own pre- and post-processing steps. Both were internal implementation details: the processor list is hardcoded in an internal trait, so there was no supported way to register the class, and the markers only ever existed part-way through a single conversion. Neither is documented in the changelog or upgrade guide for that reason. Labels are now resolved on the syntax tree by `PrepareCodeBlocks`.
- Changed the generated HTML for fenced code blocks, which now comes from the Blade view. Site output is not part of the backward compatibility promise, so this is noted for awareness rather than as a breaking change. The `hyde-code-block` and `hyde-code-block-label` classes are stable hooks for projects styling code blocks from their own CSS.

- Removed the legacy `checkForDeprecatedRunMixCommandUsage` check and the placeholder `--run-dev`/`--run-prod` options from the `build` command, which were kept in v2 only to surface a helpful error message. ([#2461](https://github.com/hydephp/develop/pull/2461))
- Removed the deprecated `hyde.server.dashboard` boolean config check from `DashboardController::enabled()`, which was kept in v2 for backwards compatibility but had since then been replaced with `hyde.server.dashboard.enabled`. ([#2461](https://github.com/hydephp/develop/pull/2462))
- Upgraded the bundled `vite` dependency from v7 to v8, and widened the `hyde-vite-plugin`'s `vite` peer dependency range from `>=6.3.5 <8.0.0` to `>=6.3.5 <9.0.0` so downstream projects can adopt Vite 8 without waiting for a new plugin major. The plugin's build config now targets Vite 8's Rolldown-based bundler (`rolldownOptions` instead of `rollupOptions`). ([#2414](https://github.com/hydephp/develop/pull/2414))

### Breaking Changes

- Renamed the static page class property `$fileExtension` to `$sourceExtension`, and the `fileExtension()` and `setFileExtension()` methods to `sourceExtension()` and `setSourceExtension()`, making it explicit that these APIs describe source files. Custom page classes and code calling these APIs need the mechanical rename, which the planned automated upgrade script will handle (see the upgrade script rules section at the end of this document).
- Removed the `GenerateSitemap` post-build task, as the sitemap is now generated through the page and route system. Sites that just enable or disable the sitemap through configuration are unaffected. Code referencing the task class — like a user-land `GenerateSitemap` build task relying on the same-basename override mechanism to replace the framework task — should bind a custom `SitemapGenerator` in the container instead. The `build:sitemap` command now compiles the registered page, and fails with an error (exit code 1 instead of 3) when the sitemap cannot be generated — because no base URL is configured or it is disabled in the configuration — instead of generating it anyway in the latter case.
- Removed the `GenerateRssFeed` post-build task, as the RSS feed is now generated through the page and route system. Sites that just enable or disable the feed through configuration are unaffected. Code referencing the task class — like a user-land `GenerateRssFeed` build task relying on the same-basename override mechanism to replace the framework task — should bind a custom `RssFeedGenerator` in the container instead. The `build:rss` command now compiles the registered page, and fails with an error when the feed cannot be generated (no base URL, disabled in the configuration, or no Markdown posts), instead of silently generating an empty feed.
- Removed `Redirect::create()`, `Redirect::store()`, and the `Redirect` constructor's `showText` argument. Redirects must now be declared in `hyde.redirects`, keeping all generated output inside the kernel-owned build graph. Redirect routes are intrinsically excluded from navigation menus and sitemaps, and always include an accessible fallback link.
- Removed the `InMemoryPage` instance macro API. Dynamic contents should now be supplied with a closure, while custom methods and other behavior belong in an `InMemoryPage` subclass.
- Removed `InMemoryPage` content-source precedence. Calls that previously supplied both `contents` and `view` must retain only the intended source; positional view calls that used an empty-string contents placeholder must use `null` instead.

- Removed the `// filepath:` code block comment syntax, along with its `#`, `/* */`, and `<!-- -->` variants. Labels are set with the `title="…"` modifier instead. A comment left behind is no longer recognized, so it stays in the code as an ordinary first line rather than being silently dropped.
- Removed the `components/filepath-label.blade.php` view. The label markup now lives in `components/markdown/code-block.blade.php` alongside the rest of what surrounds the code. **A published copy of the old view is ignored after upgrading**, and the site renders with the shipped label until the customizations are ported over. That is the intended outcome: published views take precedence over the framework's own, and a copy written for the label's old position inside `<code>` places it outside the code block entirely, so keeping the view in use could have produced incorrect layouts for those customized copies.
- Removed the `rebuild` command (`RebuildPageCommand`). It was originally added to build a single file to disk before the realtime compiler existed, and later used internally by the RC to build-and-serve a path, but the RC now renders everything in-memory, leaving `rebuild` with no remaining consumer. It also had no safe user-facing use case: a single-page build only produces a correct `_site` when the page is self-contained, while a page change routinely invalidates aggregate outputs (sitemap, RSS, search index, post listings, navigation), so single-path building could silently leave a stale output directory that looked complete. The underlying single-page build capability remains available internally via the `StaticPageBuilder` action. ([#2490](https://github.com/hydephp/develop/pull/2490))

### Upgrade guide

Please fill in UPGRADE.md as you make changes.

- Blade in Markdown is now enabled by default, including `[Blade]:` directives and the new executable `blade render` and `blade component="name"` fenced code blocks. Existing projects with a published `config/markdown.php` retain their current `markdown.enable_blade` setting; set it to `true` to adopt the v3 default, or keep it `false` to disable both forms when compiling untrusted or unreviewed Markdown.
- Raw HTML in Markdown is now enabled by default. Existing projects with a published `config/markdown.php` retain their current `markdown.allow_html` setting; set it to `true` to adopt the v3 default, or keep it `false` when compiling untrusted or unreviewed Markdown.
- Blog posts marked `draft: true` or dated in the future are no longer built, though they remain visible when serving the site. Check `_posts` for both, correcting any mistyped dates and reviewing any existing `draft: true` annotations, which now gain built-in publication behavior. If you want to schedule posts, set up recurring builds, as a scheduled post is only published by a build run after its date has passed.
- The `rebuild` command has been removed. If you need to build a single page programmatically, use `Hyde\Framework\Actions\StaticPageBuilder::handle()` instead.
- Move any calls to `Redirect::create()` or `Redirect::store()` into the `redirects` array in `config/hyde.php`, using the old path as the key and the destination as the value.
- Move `InMemoryPage` `compile` macro callbacks into the contents argument, and replace other instance macros with methods on an `InMemoryPage` subclass.
- Update `InMemoryPage` calls to supply only `contents` or `view`. Replace an empty-string positional contents placeholder with `null`, or use the named `view` argument.
- Add `navigation.visible: true` or `navigation.hidden: false` to non-HTML pages that should remain in automatic navigation, and review that matter where it was previously a no-op, like on blog posts and pages in hidden subdirectories, as it now shows them.
- Rename `$fileExtension` to `$sourceExtension` in custom page classes, and update any calls to `fileExtension()` or `setFileExtension()` to `sourceExtension()` and `setSourceExtension()`.
- If you referenced the removed `GenerateSitemap` or `GenerateRssFeed` build task classes (for example to override one with a same-basename user-land task), customize the output by binding a replacement `SitemapGenerator` or `RssFeedGenerator` in the `register()` method of a service provider.
- Replace `// filepath:` code block comments with the `title="…"` fence modifier, including the `#`, `/* */`, and `<!-- -->` comment variants.
- Compare a few pages against your old site if you have custom CSS for code blocks or their labels, since the generated markup changed. The `hyde-code-block` and `hyde-code-block-label` classes are stable hooks to target instead of the markup structure.
- Port any customizations from a published `filepath-label.blade.php` to `markdown/code-block.blade.php`. The old file is ignored after upgrading, so the site renders with the shipped label until they are moved.

## `InMemoryPage` content-source motivation

The earlier v3 redesign allowed a page to receive both `contents` and `view`, then resolved the invalid state by giving
contents precedence. This made the configured view silently irrelevant and required special handling for empty strings
and closures returning empty strings. It also left the caller's intent unclear.

The v3 API keeps both constructor arguments because they express distinct, useful strategies and preserve readable
named-argument calls. It does not infer registered views from strings passed as contents, since doing so would make a
literal string change meaning based on the application's registered views. Instead, `contents` and `view` are explicit,
mutually exclusive alternatives and ambiguous construction fails immediately.

Both arguments use `null` as the omission sentinel so an explicitly empty literal remains distinguishable from an
omitted contents argument. Their names and order remain unchanged to keep the upgrade mechanical: existing named calls
are unaffected, while positional view calls replace their old `''` placeholder with `null`.

## Blade Block component syntax motivation

The Blade Block component directive was initially prototyped as a function call, `blade component(name)`, before being
settled as an HTML-style attribute, `blade component="name"`. Since neither form shipped in a release, the released
documentation only describes the attribute form.

The attribute form was chosen because it matches how component names are already written in Blade itself, most
directly in Laravel's `<x-dynamic-component component="name" />`, so the directive reads like the Blade it renders
rather than like a PHP call. It also extends cleanly: fenced code block info strings conventionally carry
space-separated attributes, so future directives can add options next to the existing one without inventing an
argument list or changing the shape of what is already documented.

Double quotes are canonical, since that is the prevailing convention in both HTML and Blade component tags. Single
quotes are accepted as an equivalent alternative, matching HTML's tolerance for either, while an unquoted or partially
quoted value is rejected rather than guessed at. The name may not contain whitespace, keeping the info string
parseable as space-separated tokens for the extensibility noted above.

## Terminal block title syntax motivation

The terminal block title uses the same attribute syntax as the Blade Block component directive, `title="Build output"`,
which is what the extensibility argument above anticipated: the info string grammar is now `terminal [xml] [title="…"]`,
with the title sitting next to the existing modifier instead of replacing or reshaping it.

Beyond the internal consistency, `title="…"` is the established convention for this exact thing elsewhere. Docusaurus
uses it for titled fenced code blocks, and Expressive Code uses it specifically for terminal window titles, so readers
coming from other documentation generators recognize it without being taught. It also fits CommonMark, which treats the
first word of the info string as the language and deliberately leaves the rest for implementations to interpret.

Quoting follows the component directive: double quotes canonical, single quotes equivalent
(useful when the title itself contains a double quote), and an unquoted or unterminated value rejected rather than
guessed at. Unlike a component name, a title may
contain whitespace, which is exactly why it is quoted; the quotes keep the rest of the info string parseable as
space-separated tokens.

Rejecting a malformed title departs from how the block treats an unknown modifier, which is ignored so that a modifier
added in a future version does not break a page rendered by an older one. The asymmetry is deliberate: `title=Build` is
not a modifier this version doesn't know about, it is one it does know about, written wrong, and silently discarding it
would leave an author looking at a window still labelled `Terminal` with nothing to explain why. Malformed forms such
as `title`, `title=Build`, and `title = "Build"` are rejected explicitly because they are recognizable attempts to use
a supported modifier. Tokens are also matched only at whitespace boundaries, preventing a modifier from being
recognized inside a larger malformed token such as `title="One"more`.

The title is passed to the view verbatim as a nullable string rather than pre-resolved to the default label, so that a
published view can define its own fallback for untitled blocks, which the shipped view demonstrates with
`{{ $title ?? 'Terminal' }}`. An explicitly empty title is therefore distinguishable from an omitted one, and omits
the title bar entirely.

## Terminal formatting tag motivation

Hyde's terminal formatting syntax is inspired by the console formatter syntax used by Symfony Console and Laravel, so
the markup is the one an author already writes in their own commands instead of a second vocabulary invented for
documentation. It is intentionally Hyde-specific and does not aim to provide compatibility with Symfony's formatter:
Hyde supports the subset useful for documentation and may evolve it independently. The tags are written by hand to
annotate output pasted as plain text, since a formatter turns them into escape codes before anything a reader could
copy ever reaches the terminal.

The syntax is the four named styles, the `fg`, `bg`, and `options` attributes separated by semicolons, and the `</>`
shorthand closing tag. The colors are the sixteen ANSI colors, taken from the Material Palenight palette the terminal
view already uses. That is where `gray` comes from: the muted gray that console output leans on for secondary detail.

The tags are interpreted automatically, without a modifier opting into them, since they are part of what a terminal
block is. Unsupported syntax stays literal text, and a leading backslash escapes a tag, but only where the tag would
otherwise be styled, since `\<` is ordinary shell and regular expression syntax that a terminal block has to leave
alone. An attribute tag is only a style tag when the whole of it is a semicolon-separated list of attribute pairs, so
a stray word does not make the rest of a malformed tag take effect.

The supported set is deliberate. `strikethrough` is a Hyde addition, having an obvious rendering on a page and an
obvious use in documentation. Options with no sound rendering on a page, such as blinking, reversing, and concealing,
are not supported, nor are hyperlink or default-color attributes, since each would amount to a tag that is recognized
and then does nothing. They stay literal text, as unknown colors, options, and attributes already do.

Tags nest, so a tag written inside another adds its styling to it. A terminal instead resets whatever the inner style
does not set, which means an `fg` nested inside a `bg` keeps the background here where a terminal would drop it.
Composition is what an author writing `<info>… <options=bold>…` expects, and the resetting rule exists because of how
ANSI escape codes stack, which markup is not constrained by.

The formatter emits semantic `hyde-terminal-*` classes, with their default styling provided by the HydeFront terminal
component stylesheet. This keeps terminal styling independent of Tailwind's source scanning and provides stable hooks
for customization.

## Terminal block view model motivation

The data handed to the terminal view is assembled by a class, `TerminalBlockViewModel`, rather than by a renderer
building an array inline. This is purely an internal cleanup: the shape of that data was agreed on in three places with
nothing enforcing it, and a typo in any of them was a runtime surprise. A typed class means the PHP-side view-data
assembly and types are centralized, and the transformer and renderer are checked against it. Nothing about the feature
changes, and the view is given exactly the variables it was given before.

It is a plain class rather than an `Illuminate\View\Component`. The component base class was tried first, since these
blocks do render Blade views, but nothing it offers is used for an internal class: there are no attributes to merge, no
slot, and no tag to register. What it does bring is reflection-based view data, which passes a component's public
methods to the view alongside its properties, so the exact thing the class exists to pin down would have been the one
thing left implicit. A declared `viewData()` is both smaller and stricter.

The syntax tree node holds the view model rather than restating its properties, which keeps one source of truth for the
block's shape and leaves the node and renderer as the thin CommonMark adapters they should be. The view model is built
while transforming the document, so the parsed block and its data are created together. Nothing is rendered early by
this, as the formatting is string work without invoking Blade or rendering the outer view early.

Ideas that came up while doing this, and were deliberately left out because the feature was not wrong and this change
is meant to be invisible: passing the finished body as an `HtmlString` so a view can echo it with either syntax,
passing the unrendered output alongside it for views that want a copy button, and exposing the class publicly so a
terminal window could be rendered from PHP without writing Markdown. Each is a feature change and belongs in its own
change, judged on its own merits.

More blocks may gain the same backing later, which is also a separate change; terminal blocks are the only one today.

## Composable code block motivation

Code blocks were the last Markdown construct still assembled by string manipulation. A pre-processor rewrote filepath
comments into `<!-- HYDE[Filepath] -->` markers, and a post-processor spliced the rendered label back into the finished
HTML with a regex matching `<pre><code class="language-…">`. That approach limited what the feature could ever be: the
label could only be a fragment placed inside the `<code>` element, because that was the only place a string
replacement could reach. There was nowhere to put a copy button, a header bar, or a collapsed state.

Rendering the whole block through a Blade view removes that limit. The view owns the markup around the code, so
changing what surrounds a code block becomes a view change instead of a framework change, which is what terminal
blocks already offer.

The view is given the rendered code block markup rather than the raw code, which is what keeps highlighting working.
Torchlight highlights through its API, so Hyde cannot render the code itself without replacing the highlighter.

Getting hold of that markup is the whole design problem, because the highlighter is another renderer registered for
the same node, and CommonMark's registry is not a middleware chain. The document renderer owns the iteration, asking
each renderer in priority order and stopping at the first non-null result, and a node renderer only ever receives a
`ChildNodeRendererInterface`, which renders child nodes and offers no way to call the next renderer.

Three attempts are worth recording, because each one failed for a reason that shaped the next.

The first reached back into the environment with `getRenderersForClass()` and called the renderers below itself,
replaying the dispatcher by hand with no cursor for which renderers had already been tried.

The second named Torchlight directly and injected it, with a fallback to CommonMark's renderer. That only worked for
the highlighter we happen to ship with: a project using any other one got its code rendered by the fallback instead.

The third rendered the node through a second converter built from the same extensions but without Hyde's renderer.
That was highlighter-agnostic on the surface and wrong underneath. Registering an extension with two environments
calls `register()` twice, so an extension that creates state there — a listener and a renderer sharing a collection,
which is the ordinary way to write a highlighter — ends up with the document populating one copy and the renderer
reading the other. It also invoked any renderer above Hyde's twice for the same block, once per environment, and
skipped the document render events that `renderDocument()` dispatches but `renderNodes()` does not.

What it settled on is structural rather than a second dispatch. Once the document is parsed and every listener has
seen it, each remaining `FencedCode` is wrapped in a `CodeBlock` node of Hyde's own, and it is that wrapper the
renderer is registered for. The fence is still in the tree, as the wrapper's only child, and rendering it through the
`ChildNodeRendererInterface` the renderer is handed dispatches it back through the same environment — where Hyde is
not a candidate, because Hyde renders `CodeBlock`, not `FencedCode`.

One environment, one registration per extension, and each fence rendered exactly once by whoever the environment
already had for it. Priority stops being part of the contract: a highlighter renders inside the view whether it
registers above or below anything of ours. A block is only taken over completely by replacing the node itself, which
is a deliberate act rather than a side effect of picking a number.

Wrapping happens on `DocumentPreRenderEvent` at the lowest priority, so every parse-time listener has already run
against a tree shaped the way it expects. The label is resolved separately, on `DocumentParsedEvent`, above the
priority listeners register at by default, so a highlighter collects fences that have already had the Hyde syntax
taken out of them. The old pre-processor achieved the same thing by running before the parser.

The title modifier is taken out of the info string once it has been read: CommonMark treats the first info word as the
language, so a fence that sets only a title would otherwise hand `title="foo.php"` to the highlighter as one. Other
modifiers are left alone, since a highlighter may read its own from there, as Torchlight does with `theme:`.

The syntax is `title="…"`, the terminal block title modifier applied to code blocks, which is the kind of reuse the
extensibility argument for that syntax anticipated. It also matches what Docusaurus and Expressive Code call the same
thing, so readers coming from other documentation generators will recognize it.

A fence may set a title without a language, which the terminal block case never had to consider, since its first word
is always `terminal`. The first info token is therefore only taken as the language when it does not look like a title
modifier. That also keeps the error for a malformed title consistent, so ` ```title=Foo ` is rejected the same way
` ```php title=Foo ` is, rather than being quietly read as a language named `title=Foo`.

A `blade` fence carrying a title is a labelled code sample rather than a block to execute, so the Blade block
extractor leaves it to the code block pipeline instead of reporting an unknown directive. It reads the fence through
the same tokenizer the code block parser uses, so modifier order does not matter and a `title=` written inside another
modifier's quoted value is not read as one. Splitting the info string on whitespace instead would accept
` ```blade meta='a title="x" b' ` as a code sample rather than reporting the unknown directive it is.

The label markup lives in the code block view rather than a view of its own. It is a single element with no logic to
reuse, and the code block view is short enough that anyone changing its markup can edit it in place, while anyone only
restyling it has the `hyde-code-block-label` class hook. A second view would have added a public view name, another
publishable file, and another migration target, for no customization that is not already possible.

The v2 `filepath-label.blade.php` view is therefore removed rather than kept. Published views take precedence over the
framework's own, so keeping it would have left every customized copy in use, and a copy written for the old position
can float the label outside the code block once the label is no longer inside the `<code>` element. Removing the view
means such a copy is ignored instead, costing the customization rather than the page.

`CodeBlockViewModel` is internal, matching `TerminalBlockViewModel`. It exists to type the view data and document its
shape in one place, not to be an entry point: a code block is rendered by writing Markdown, and the interface projects
work against is the Blade view, not the class that feeds it. Exposing it publicly was considered and dropped, since
nothing needs it yet and a public class is much harder to take back than to add.

The wrapper carries the block's vertical margins and zeroes the fence's own. The prose stylesheet resets the top
margin of whatever follows a heading or opens the container, and those selectors now match the wrapper rather than the
`<pre>`. Leaving the margin on the fence would collapse it straight back out through the border-less wrapper, putting a
gap after every heading that v2 never had.

The view is given a `$language` variable it does not currently use, because it is intrinsic to the block and views
building their own header bars want it. It was not given a flag for whether Torchlight produced the markup. The v2
label needed one to offset its position, but the wrapper makes that offset uniform, so the flag would have been view
data that nothing reads, and it would have named a specific highlighter in the view contract.

The extension registration model is unchanged by all of this. Torchlight is registered by class name exactly as it was
in v2, each extension is constructed once for one environment, and the code block wiring sits alongside the heading
renderer in the converter setup, where the rest of Hyde's own rendering already lives.

The preparation listener is the one piece registered out of line: it goes on before any extension, at the highest
priority, because listeners sharing a priority run in registration order and a third-party listener is free to claim
the same number. Wrapping is the mirror of that, registered afterwards at the lowest priority, so it happens once
every other listener has had the document in the shape it expects.

## Dropping the filepath comment syntax

An intermediate v3 branch supported both syntaxes, with the modifier winning when a block set both. That was dropped in
favour of one syntax, and the comment removed entirely.

The comment's one real advantage was portability. `// filepath: app/Model.php` still conveys the file when the same
Markdown is read somewhere that knows nothing about Hyde, such as a GitHub pull request. That is not worth what it
costs: it says the label must be a file path when the label is really a title, it puts presentation metadata inside
the displayed code, it needs a comment variant per language, it makes Hyde delete a line that could be legitimate
first-line code, and it doubles the syntax, documentation, and tests for a small feature. Two syntaxes also need
precedence rules, and precedence rules need explaining. Degrading to a plain code block elsewhere is acceptable for
framework-specific presentation metadata, which is how `title="…"` already behaves for terminal blocks.

Keeping the comment working at runtime was rejected as well. Nothing on the v3 branch is released, so the only
compatibility question is with v2, and that is a one-time migration rather than a permanent second syntax. Recognizing
the comment only to warn about it would have kept every cost above, minus the label.

The migration is mechanical and belongs in the v3 upgrade script rather than in the framework. It should work on parsed
fenced blocks rather than a document-wide regex, so it should:

- only inspect the first line of a fenced code block;
- accept every comment form v2 documented, including the closing delimiters of `/* */` and `<!-- -->` comments;
- preserve the language and any other fence modifiers, and add no second title when the fence already has one;
- take the blank line separating the old comment from the code with it;
- quote the title with single quotes when the label contains a double quote;
- leave anything it cannot express unchanged and report it for manual migration, which is what a label containing both
  quote characters needs.

The framework's own documentation was migrated the same way, and every label in it converted cleanly, which is the
evidence that the mechanical rules above cover realistic usage.

The v2 option gating the feature, `markdown.features.codeblock_filepaths`, is dropped rather than renamed. It was
absent from the published `config/markdown.php` and was never documented, and titles are opt-in syntax already, so
there is nothing for a global switch to do that leaving `title="…"` off the fence does not.

---

## Upgrade script rules

We will provide an automated upgrade script (likely Rector-based) when we finalize the release.
Until then, this section collects the rules that script needs to implement, so we don't lose
track of them. Add an entry here whenever a change requires mechanical migration of user code.

- Rename the static page class property `$fileExtension` to `$sourceExtension`, and the
  `fileExtension()` and `setFileExtension()` methods to `sourceExtension()` and
  `setSourceExtension()`. This covers property declarations in page classes
  (`public static string $fileExtension = '.md';`), direct static property access
  (`MarkdownPage::$fileExtension`, `$pageClass::$fileExtension`), static method calls
  (`MarkdownPage::fileExtension()`), and method declarations that override these methods
  in page classes (`public static function fileExtension(): string`) — the methods are
  public and non-final, and an un-renamed override would silently stop being called once
  the framework calls `sourceExtension()`. The rule must be scoped to
  `Hyde\Pages\Concerns\HydePage` subclasses (or known Hyde symbols) — it must not rename
  unrelated properties or methods that happen to share the name.
- The rename must also cover named arguments: `Page::setFileExtension(fileExtension: '.md')`
  becomes `Page::setSourceExtension(sourceExtension: '.md')`, since the parameter was renamed
  along with the method. Include a dedicated Rector fixture for this case.
- Dynamic references cannot be migrated automatically and should be called out as manual
  upgrade cases: variable method/property names (`$method = 'fileExtension';
  $pageClass::$method()`), reflection, and string-based access.
