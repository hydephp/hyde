## [Unreleased] - YYYY-MM-DD

### About

Keep an Unreleased section at the top to track upcoming changes.

This serves two purposes:

1. People can see what changes they might expect in upcoming releases
2. At release time, you can move the Unreleased section changes into a new release version section.

### Added
- Added `DocumentationPage::indexPath()`, replacing `Hyde::docsIndexPath()`

### Changed
- internal: Move service provider helper methods to the RegistersFileLocations trait
- internal: Add helpers.php to reduce repeated code and boilerplate
- internal: Change internal monorepo scripts for semi-automating the release process
- Added `DocumentationPage` as a class alias, allowing you to use it directly in Blade views, without having to add full namespace.

### Deprecated
- for soon-to-be removed features.

### Removed
- Remove deprecated `Hyde::getDocumentationOutputDirectory()`, replaced with `DocumentationPage::getOutputDirectory()`
- Remove deprecated `Hyde::docsIndexPath()`, replaced with `DocumentationPage::indexPath()`
- Remove deprecated `DocumentationPage::getDocumentationOutputPath()`, use `DocumentationPage::getOutputPath()` instead

### Fixed
- Fix minor bug in Blade view registry where merged array was not unique

### Security
- in case of vulnerabilities.
