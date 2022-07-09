## [Unreleased] - YYYY-MM-DD - Internal Pseudo-Router Service Refactoring

### About

This release brings a massive refactor in the way the HydePHP auto-discovery process works. It does this by centralizing all discovery logic to the new pseudo-router module which discovers and maps all source files and output paths.

The update also refactors related code to use the router. Part of this is a major rewrite of the navigation menu generation. If you have set any custom navigation links you will need to update your configuration files as the syntax has changed to use the NavItem model instead of array keys.

You will also need to update navigation related Blade templates, if you have previously published them.

### Added
- Added a pseudo-router module which will internally be used to improve Hyde auto-discovery
- Added a Route facade that allows you to quickly get a route instance from a route key or path
- Added a new NavItem model to represent navigation menu items
- Added a new configuration array for customizing the navigation menu, see the `hyde.navigation` array config

### Changed
- Changed how the navigation menu is generated, configuration files and published views must be updated
- Reversed deprecation for `StaticPageBuilder::$outputPath`
- internal refactor: Creates a new build service to handle the build process

### Deprecated
- Deprecated `DiscoveryService::findModelFromFilePath()` - Use the Router instead.

### Removed
- The "no pages found, skipping" message has been removed as the build loop no longer recieves empty collections.
- Removed the `hyde.navigation_menu_links` and `hyde.navigation_menu_blacklist` configuration options, see new addition above. 
