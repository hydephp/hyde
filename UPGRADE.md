# HydePHP v2.0 Upgrade Guide

## Overview

HydePHP v2.0 represents a major evolution of the framework, introducing significant improvements to the asset system, navigation API, and overall developer experience. This release modernizes the frontend tooling by replacing Laravel Mix with Vite, completely rewrites the navigation system for better flexibility, and introduces numerous performance optimizations throughout the framework.

This document will guide you through the upgrade process. If you want to learn more about the new features, take a look at the [Release Notes](https://hydephp.com/docs/2.x/release-notes).

## Before You Begin

### Prerequisites

Before upgrading to HydePHP v2.0, ensure your application is running **HydePHP v1.6 or later** (ideally v1.8). These versions include transition helpers that will make the migration process smoother.

### Backup Your Project

Before starting the upgrade process, it's **strongly recommended** to:

- **Commit all changes to Git** - This allows you to easily revert if needed
- **Create a backup** of your entire project directory
- **Have a previous site build** so you can compare output

If you're not already using Git for version control, now is an excellent time to initialize a repository:

```bash
git init
git add .
git commit -m "Pre-upgrade backup before HydePHP v2.0"
```

### Estimated Time

The upgrade process typically takes **30-60 minutes** for most projects. Complex sites with extensive customizations may take up to 90 minutes. The majority of this time involves:

- Updating and installing dependencies (~15 minutes)
- Migrating configuration files (~20 minutes)
- Testing and verifying the site (~15-30 minutes)

## Step 1: Update Dependencies

### Update Composer Dependencies

Open your `composer.json` file and update the following dependencies:

```json
{
    "require": {
        "php": "^8.2",
        "hyde/framework": "^2.0",
        "laravel-zero/framework": "^11.0"
    },
    "require-dev": {
        "hyde/realtime-compiler": "^4.0"
    }
}
```

Then run:

```bash
composer update
```

The dump-autoload script will likely fail, but this is expected and will be resolved in subsequent steps.

### Update Node Dependencies

Open your `package.json` file and replace the entire `devDependencies` section:

**Before (v1.x with Laravel Mix):**
```json
{
    "devDependencies": {
        "@tailwindcss/typography": "^0.5.2",
        "autoprefixer": "^10.4.5",
        "hydefront": "^3.4.1",
        "laravel-mix": "^6.0.49",
        "postcss": "^8.4.31",
        "tailwindcss": "^3.0.24"
    }
}
```

**After (v2.x with Vite):**
```json
{
    "type": "module",
    "devDependencies": {
        "@tailwindcss/typography": "^0.5.0",
        "@tailwindcss/vite": "^4.1.0",
        "autoprefixer": "^10.4.0",
        "hyde-vite-plugin": "^1.1.0",
        "hydefront": "^4.0.0",
        "postcss": "^8.5.0",
        "tailwindcss": "^4.1.0",
        "vite": "^7.1.0"
    }
}
```

Update the NPM scripts in your `package.json`:

```json
{
    "scripts": {
        "dev": "vite",
        "build": "vite build"
    }
}
```

Then run:

```bash
npm install
```

## Step 2: Migrate from Laravel Mix to Vite

### Delete the Old Mix Configuration

Remove the `webpack.mix.js` file from your project root.

### Create the New Vite Configuration

Create a new `vite.config.js` file in your project root:

```javascript
import { defineConfig } from 'vite';
import tailwindcss from "@tailwindcss/vite";
import hyde from 'hyde-vite-plugin';

export default defineConfig({
    plugins: [
        hyde({
            input: ['resources/assets/app.css', 'resources/assets/app.js'],
            watch: ['_pages', '_posts', '_docs'],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
```

### Update Your CSS imports

Update `resources/assets/app.css`:

**Before:**
```css
@import '~hydefront/dist/hyde.css';

@tailwind base;
@tailwind components;
@tailwind utilities;

[x-cloak] { display: none !important; }
```

**After:**
```css
@import 'hydefront/components/torchlight.css' layer(base);

@import 'tailwindcss';

@config '../../tailwind.config.js';
```

## Step 3: Upgrade Tailwind CSS to v4

Run the automated Tailwind upgrade tool:

```bash
npx @tailwindcss/upgrade
```

Review the [Tailwind v4 Upgrade Guide](https://tailwindcss.com/docs/upgrade-guide) for detailed information about breaking changes in custom configurations.

## Step 4: Verify Vite Works

Now you can run Vite build:

```bash
npm run build
```

## Step 5: Update Configuration Files

### Update `config/hyde.php`

#### Replace Features With Enum Values

**Before:**
```php
'features' => [
    Features::htmlPages(),
    Features::markdownPosts(),
],
```

**After:**
```php
'features' => [
    Feature::HtmlPages,
    Feature::MarkdownPosts,
],
```

#### Update Navigation Configuration

**Before:**
```php
'navigation' => [
    'custom_items' => [
        'Custom Item' => '/custom-page',
    ],
],
```

**After:**
```php
'navigation' => [
    'custom' => [
        ['label' => 'Custom Item', 'destination' => '/custom-page'],
    ],
],
```

Or use the Navigation facade:

```php
use Hyde\Facades\Navigation;

'navigation' => [
    'custom' => [
        Navigation::item('https://github.com/hydephp/hyde', 'GitHub', 200),
    ],
],
```

#### Update Subdirectory Display Setting

**Before:**
```php
'navigation' => [
    'subdirectories' => 'hidden',
],
```

**After:**
```php
'navigation' => [
    'subdirectory_display' => 'hidden',
],
```


### Update Author Configuration

If you're using blog post authors, update the configuration format:

**Before:**
```php
'authors' => [
    Author::create('username', 'Display Name', 'https://example.com'),
],
```

**After:**
```php
'authors' => [
    'username' => Author::create(
        name: 'Display Name',
        website: 'https://example.com',
        bio: 'Author bio',
        avatar: 'avatar.png',
        socials: ['twitter' => '@username']
    ),
],
```

#### Rename Cache Busting Setting

**Before:**
```php
'enable_cache_busting' => true,
```

**After:**
```php
'cache_busting' => true,
```

#### Remove Deprecated HydeFront Settings

Remove these configuration options (they're now handled automatically):

```php
'hydefront_version' => ...,
'hydefront_cdn_url' => ...,
```

### Update `config/docs.php`

Reorganize the sidebar configuration:

**Before:**
```php
'sidebar_order' => [
    'readme',
    'installation',
],

'table_of_contents' => [
    'enabled' => true,
],

'sidebar_group_labels' => [
    // ...
],
```

**After:**
```php
'sidebar' => [
    'order' => [
        'readme',
        'installation',
    ],
    
    'labels' => [
        // ...
    ],

    'table_of_contents' => [
        'enabled' => true,
        'min_heading_level' => 2,
        'max_heading_level' => 4,
    ],
],
```

### Update `app/config.php`

Add the new navigation service provider under the `'providers'` array:

```php
Hyde\Foundation\Providers\NavigationServiceProvider::class,
```

And add the following classes to the `'aliases'` array:

```php
'Vite' => \Hyde\Facades\Vite::class,
'MediaFile' => \Hyde\Support\Filesystem\MediaFile::class,
```

## Step 6: Update Code References

### Routes Facade API Changes

**Before:**
```php
$route = Routes::get('route-name');        // Returns null if not found
$route = Routes::getOrFail('route-name');  // Throws exception
```

**After:**
```php
$route = Routes::find('route-name');       // Returns null if not found
$route = Routes::get('route-name');        // Throws exception
```

### Asset API Updates

If you're using asset methods in custom code, note that they now return `MediaFile` instances:

```php
// Methods renamed for clarity
Hyde::asset('image.png');          // Previously: Hyde::mediaLink()
Asset::get('image.png');           // Previously: Asset::mediaLink()
Asset::exists('image.png');        // Previously: Asset::hasMediaFile()
HydeFront::cdnLink('app.css');     // Previously: Asset::cdnLink()
MediaFile::sourcePath('image.png') // Previously: Hyde::mediaPath()
```

The `MediaFile` instances are Stringable and will automatically resolve to relative links, so in most cases (especially in Blade templates), no code changes are needed.

### Includes Facade Return Types

Methods now return `HtmlString` objects instead of raw strings:

**Before:**
```blade
{!! Includes::html('partial') !!}
```

**After:**
```blade
{{ Includes::html('partial') }}
```

**Security Note:** Output is no longer escaped by default. If you're including user-generated content, use `{{ e(Includes::html('foo')) }}` for escaping.

### DataCollections Renamed

**Before:**
```php
use Hyde\Support\DataCollections;
```

**After:**
```php
use Hyde\Support\DataCollection;
```

## Step 7: Update Build Commands

Update any CI/CD pipelines or build scripts:

**Before:**
```bash
npm run prod
php hyde build --run-prod
```

**After:**
```bash
npm run build
php hyde build --vite
```

The `--run-dev`, `--run-prod`, and `--run-prettier` flags have been removed. Use `--vite` instead.

## Step 8: Clear Caches

Next, to ensure we have a clean slate, run the following commands:

```bash
composer dump-autoload
php hyde cache:clear
rm app/storage/framework/views/*.php
```

You may also want to republish any views you have published.

## Step 9: Rebuild Your Site

After completing all the configuration updates:

```bash
npm run build

# Build your site
php hyde build

# Or use the realtime compiler for development
php hyde serve
```

## Step 10: Test Your Site

1. Test all navigation menus for correct ordering and appearance
2. Verify media assets are loading correctly
3. Check that all pages render properly
4. Test the search functionality (if using documentation)
5. Verify author information displays correctly on blog posts
6. Test dark mode if you're using theme toggle buttons

## Migration Checklist

Use this checklist to track your upgrade progress:

- [ ] Confirmed running HydePHP v1.6+ (preferably v1.8)
- [ ] Updated `composer.json` dependencies
- [ ] Ran `composer update`
- [ ] Updated `package.json` dependencies and scripts
- [ ] Added `"type": "module"` to `package.json`
- [ ] Ran `npm install`
- [ ] Deleted `webpack.mix.js`
- [ ] Created `vite.config.js`
- [ ] Updated `resources/assets/app.css` imports
- [ ] Ran `npx @tailwindcss/upgrade` for Tailwind v4
- [ ] Updated `config/hyde.php` features to use enum values
- [ ] Updated navigation configuration to array format
- [ ] Renamed `enable_cache_busting` to `cache_busting`
- [ ] Removed deprecated HydeFront settings
- [ ] Updated author configuration format (if using blog)
- [ ] Reorganized sidebar configuration in `config/docs.php`
- [ ] Updated Routes facade method calls (if used in custom code)
- [ ] Updated Includes facade usage (if used in custom views)
- [ ] Renamed DataCollections to DataCollection (if used)
- [ ] Ran `npm run build`
- [ ] Ran `php hyde build`
- [ ] Tested site menus for correct ordering and appearance
- [ ] Verified media assets load correctly
- [ ] Checked all pages render properly
- [ ] Tested documentation search (if applicable)
- [ ] Verified blog author information (if applicable)

## Troubleshooting

### Assets Not Compiling

If you encounter issues with asset compilation:

1. Delete `node_modules` and `package-lock.json`
2. Run `npm install` again
3. Clear the `_media` directory
4. Run `npm run build`

### Missing Routes

If you get `RouteNotFoundException` errors:

- Check that you've updated `Routes::get()` to `Routes::find()` for cases where the route might not exist
- Verify your page source files are in the correct directories

### Validation Errors

If you get syntax validation errors from DataCollection:

- Ensure all your YAML/JSON data files have valid syntax
- Empty data files are no longer allowed in v2.0

### Errors During build

If you have published Blade views, those may need to be republished if they use old syntax. If you use custom code you may need to look closer at the full release diff.

## Getting Help

If you encounter issues during the upgrade:

- **Documentation**: [https://hydephp.com/docs/2.x](https://hydephp.com/docs/2.x)
- **GitHub Issues**: [https://github.com/hydephp/hyde/issues](https://github.com/hydephp/hyde/issues)
- **Community Discord**: [https://discord.hydephp.com](https://discord.hydephp.com)

For the complete changelog with all pull request references, see the [full release notes](https://github.com/hydephp/hyde/releases/tag/v2.0.0).
