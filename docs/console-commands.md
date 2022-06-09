---
priority: 5
category: "Getting Started"
---

# Console Commands

The primary way of interacting with Hyde is through the command line using the HydeCLI.

If you have ever used the Artisan Console in Laravel you will feel right at home,
the Hyde CLI is based on Artisan after all!

## Hyde Commands

To use the HydeCLI, run `php hyde` from your project directory followed by a command.

### Documentation syntax

Wondering what the different formatting in examples means? Here's a quick guide:

```bash
<argument> # Comes after the command name.
[<argument>] # Optional argument. 

--option # Sometimes referred to as a flag.
--option=<value> # Option which takes an value.
[--option] # Optional option.
```

All HydeCLI commands start with `php hyde`. Anything in `[brackets]` is optional.
If an argument or option value has a space in it, it needs to be wrapped in quotes.



### Got stuck? The CLI can help.

You can always run the base command `php hyde`, or `php hyde list`, to show the list of commands.

```bash
php hyde # or `php hyde list`
```

You can also always add `--help` to a command to show detailed usage information.
```bash
php hyde <command> --help
```


### Initialize a new Hyde project
```bash
php hyde install         
```

While Hyde doesn't need much configuration to get started, this command speeds up the little there is.

For example, it updates the config file with the supplied site name and URL,
and can also publish a starter homepage and rebuild the site.


### Build the static site
```bash
php hyde build          
```

Maybe the most important command is the Build command, which -- you guessed it -- builds your static site!

**Supports the following options:**
```
--run-dev       Run the NPM dev script after build
--run-prod      Run the NPM prod script after build
--run-prettier  Format the output using NPM Prettier*
--no-api        Disable API calls, for example, Torchlight
```

> *Before v0.25.x this option was called `--pretty`

#### Sitemaps and RSS feeds

Sitemaps and RSS feeeds require that you have a `site_url` set, (and that you have not disabled them).

When the features are avaliable the build commnad will generate a sitemap and RSS feed.

You can also rebuild just the sitemap and RSS feed by using their respective commands:

```bash
php hyde build:sitemap
php hyde build:rss
```

### Build a single file
```bash
php hyde rebuild <filepath>       
```
Using the php hyde build command is great and all that,
but when you just need to update _that one file_ it gets a little... overkill.
To solve this problem, you can use the `rebuild` command to compile a single file.

**Requires the following Arguments:**
```
path   The relative file path
```

**Example:**
```bash
php hyde rebuild _posts/hello-world.md
```

### Start the realtime compiler.
```bash
php hyde serve          
```

The serve command feels similar to the Laravel Artisan serve command, but works by
starting a local PHP server. When you visit a page, the server will use the
realtime compiler to locate the source file, recompile it, and proxy
the resulting HTML and any media files to your browser.

If you are missing the extension, you can always reinstall it with Composer `composer require hyde/realtime-compiler`.
You can also learn more on the [GitHub page](https://github.com/hydephp/realtime-compiler).

**Supports the following options:**
```
--port[=PORT] [default: "8080"]
--host[=HOST] [default: "localhost"]
```


### Scaffold a new blog post file
```bash
php hyde make:post       
```

At the core, blog posts are just pain ol' Markdown files.
However, by adding a special YAML syntax called Front Matter, you can add metadata to your posts.
But who can remember the syntax? You can use the `make:post` command to scaffold a new blog post file.
The command will ask you a series of interactive questions, letting you fill in the blanks.
It will then create a file, converting your input into front matter. It automatically
sets the date and time for you, and the file name will be based on the title.


### Scaffold a new page file
```bash
php hyde make:page <title> [--type=TYPE]
```

The `make:page` command is similar to the `make:post` command and lets you quickly
create one of the following page types:

- **Markdown**:
 Creates a Markdown file in the `_pages` directory.
- **Blade**:
 Creates a Blade file using the app layout in the `_pages` directory.
- **Docs**:
 Creates a Markdown file in the `_docs` directory. 

In all cases, the title will be used in the created file as the page title, and to generate the filename.

**Requires the following Arguments:**
```
title   The name of the page file to create
```

**Supports the following options:**
```
--type[=TYPE] The type of page to create (markdown, blade, or docs) [default: "markdown"]
```

**Example:**
```bash
php hyde make:page About # Defaults to Markdown
php hyde make:page "Photo Gallery" --type=blade
php hyde make:page "Hyde CLI Guide" --type=docs
```

### Publish a default homepage
```bash
php hyde publish:homepage [<name>]
```

Hyde comes with three homepage options to choose from. The homepage you select is stored as
`_pages/index.blade.php` and becomes the `index.html` file when compiling the site.

On a fresh install the page 'welcome' is installed.
However, you can use this command to publish another one.
If you have modified the file, you will need to supply the --force option to overwrite it.

The available homepages are:

- **welcome:** The default welcome page. Unlike the other pages, the styles are defined inline.
- **posts:** A Blade feed of your latest blog posts. Perfect for a blog site!
- **blank:** A blank Blade template with just the base app layout.

You can supply the homepage name directly to the command, otherwise you will be prompted to select one.


### Publish the Hyde Blade views
```bash
php hyde publish:views [<category>]
```

Since Hyde is based on the Laravel view system the compiler uses Blade views and components.
Laravel actually registers two locations for the Hyde views: your site's `resources/views/vendor/hyde` directory and the `resources` directory located in the Framework package.

<blockquote class="warning">
<p>Warning: This command will overwrite any existing files in the <code>resources/views/vendor</code> directory. <br>
You should be sure to have backups, or version control such as Git, before running this command.</p>
</blockquote>

So, when compiling a site, Laravel will first check if a custom version of the view has been placed in the `resources/views/vendor/hyde` directory by the developer (you). Then, if the view has not been customized, Laravel will search the Hyde framework view directory. This makes it easy for you to customize / override the package's views.

The available views you can publish are:

- **all:** Publish all categories listed below
- **layouts:** Global layout views, such as the app layout, navigation menu, and Markdown page templates.
- **components:** More or less self-contained components, extracted for customizability and DRY code.
- **404:** A beautiful 404 error page by the Laravel Collective. This file is already published by default.

You can supply the category name directly to the command, otherwise you will be prompted to select one.

<blockquote class="info">
Note that when a view is updated in the framework you will need to republish the views to get the new changes!
</blockquote>

### Republish the configuration files
```bash
php hyde update:configs   
```

When updating Hyde to a new version (or if you mess up your config files),
you can use this command to republish the configuration files.

<blockquote class="warning">
<p>Warning: This command will overwrite any existing files in the <code>config</code> directory. <br>
You should be sure to have backups, or version control such as Git, before running this command.</p>
</blockquote>


### Run validation tests to optimize your site
```bash
php hyde validate        
```

Hyde ships with a very useful command that runs a series of checks to validate your setup and catch any potential issues.

> The validate command requires that [Pest](https://pestphp.com/) is installed.
> Pest is by default bundled as a dev-dependency with Hyde.