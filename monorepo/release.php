<?php

// # Hyde Releases
//
// While in the v0.x range, we consider both major and minor release versions to be the same. This means that when a new feature is added, it should be added as a minor version even if it is breaking. Patch versions should always be compatible. Once we reach v1.0 we will follow semantic versioning strictly.
//
// The versioning between the Framework and Hyde packages are linked together Meaning that if Hyde get's a minor release, so must Framework, and vice versa. To make this easier, we also publish minor releases in the monorepo. Patch releases are not published in the monorepo, and are instead handled by the individual packages.
//
// To make this all easier, this directory contains tools to automate part of the process. The release manager only works for minor releases as patch releases are handled by the individual packages, and we are still in the v0.x range.

// Internal script I bodged together, don't use in production, verify before committing, etc.

// Run with `php .\projects\release-manager\release.php`

echo "Preparing a new syndicated HydePHP release!\n";

echo "Using NPM for versioning...\n";

$version = trim(shell_exec('npm version minor --no-git-tag-version')).'-beta';

echo "Version: $version\n";

echo "Updating Hyde composer.json...\n";

// get just the minor number
$shortVersion = substr($version, 3);
// trim everything after the first dot
$shortVersion = substr($shortVersion, 0, strpos($shortVersion, '.'));

echo "Short version: $shortVersion\n";
$composerJson = json_decode(file_get_contents(__DIR__.'./../../packages/hyde/composer.json'), true);
$composerJson['require']['hyde/framework'] = "^0.$shortVersion";
file_put_contents(__DIR__.'./../../packages/hyde/composer.json', json_encode($composerJson, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES));

echo "Transforming upcoming release notes... \n";

$notes = file_get_contents(__DIR__.'/../../RELEASE_NOTES.md');

$notes = str_replace("\r", '', $notes);

// remove default release notes
$defaults = [
    '- for new features.',
    '- for changes in existing functionality.',
    '- for soon-to-be removed features.',
    '- for now removed features.',
    '- for any bug fixes.',
    '- in case of vulnerabilities.',
];

foreach ($defaults as $default) {
    $notes = str_replace($default, '', $notes);
}

$notes = str_replace('Keep an Unreleased section at the top to track upcoming changes.

This serves two purposes:

1. People can see what changes they might expect in upcoming releases
2. At release time, you can move the Unreleased section changes into a new release version section.', '', $notes);

$notes = trim($notes);

$notes = str_replace('## [Unreleased]', "## [$version](https://github.com/hydephp/develop/releases/tag/$version)", $notes);
$notes = str_replace('YYYY-MM-DD', date('Y-m-d'), $notes);
$notes = $notes."\n";

echo "Done. \n";

echo 'Resetting upcoming release notes stub';
file_put_contents(__DIR__.'/../../RELEASE_NOTES.md', '## [Unreleased] - YYYY-MM-DD

### About

Keep an Unreleased section at the top to track upcoming changes.

This serves two purposes:

1. People can see what changes they might expect in upcoming releases
2. At release time, you can move the Unreleased section changes into a new release version section.

### Added
- for new features.

### Changed
- for changes in existing functionality.

### Deprecated
- for soon-to-be removed features.

### Removed
- for now removed features.

### Fixed
- for any bug fixes.

### Security
- in case of vulnerabilities.
');

echo 'Updating changelog with the upcoming release notes... ';

$changelog = file_get_contents(__DIR__.'/../../CHANGELOG.md');

$needle = '<!-- CHANGELOG_START -->';

$changelog = substr_replace($changelog, $needle."\n\n".$notes, strpos($changelog, $needle), strlen($needle));
file_put_contents(__DIR__.'/../../CHANGELOG.md', $changelog);

echo "Done. \n";

$title = "$version - ".date('Y-m-d');
$body = ltrim(substr($notes, strpos($notes, "\n") + 2));
$companionBody = sprintf('Please see the release notes in the development monorepo https://github.com/hydephp/develop/releases/tag/%s', $version);

$developCreateLink = "https://github.com/hydephp/develop/releases/new?tag=$version&title=".urlencode($title).'&body='.urlencode($body);
$frameworkCreateLink = "https://github.com/hydephp/framework/releases/new?tag=$version&title=".urlencode($title).'&body='.urlencode($companionBody);
$hydeCreateLink = "https://github.com/hydephp/hyde/releases/new?tag=$version&title=".urlencode($title).'&body='.urlencode($companionBody);

echo 'Creating HTML file...';

file_put_contents(getcwd().'/release.html', <<<HTML
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Release $version</title>
</head>
<body>
    <h1>Release $version</h1>
    <details>
        <summary>Release notes</summary>
        <pre>$notes</pre>
    </details>
    <p>
        <h2>Create the Git commit</h2>
        <label>Suggested message:</label><br>
        <input readonly type="text" value="$title">
    </p>
    <p>
        <h2>Publish the GitHub releases</h2>
        <ul>
            <li style="margin-bottom: 8px";><a href="$developCreateLink">Create a new release on the <strong>development monorepo</strong></a></li>
            <li style="margin-bottom: 8px";><a href="$frameworkCreateLink">Create a new release on the <strong>framework repo</strong></a></li>
            <li style="margin-bottom: 8px";><a href="$hydeCreateLink">Create a new release on the <strong>hyde repo</strong></a></li>
        </ul>
    </p>
</body>
</html>
HTML
);

echo "Done. \n";

echo "\nAll done!\nNext, verify the changes, then you can commit the release with the following message: \n";
echo "$title\n";
echo "And here is a link to publish the release: \n";
echo "$developCreateLink\n";

echo "\n\nThen you can use the following to to create the companion releases: \n";
echo "$frameworkCreateLink\n";
echo "$hydeCreateLink\n";

echo "\nYou can also open the following file in your browser, to create the releases through that: \n";
echo 'file://'.str_replace('\\', '/', getcwd()).'/release.html';
