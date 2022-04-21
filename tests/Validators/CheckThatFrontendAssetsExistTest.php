<?php

test('check that hyde.css exists', function () {
    if (! file_exists('_site/media/hyde.css')) {
        $this->addWarning('Could not find the `Hyde.css` stylesheet in the build directory. You may need to run `php hyde update:assets`.');
    } else {
        $this->assertTrue(true);
    }
})->group('validators');

test('check that hyde.js exists', function () {
    if (! file_exists('_site/media/hyde.js')) {
        $this->addWarning('Could not find the `Hyde.js` stylesheet in the build directory. You may need to run `php hyde update:assets`.');
    } else {
        $this->assertTrue(true);
    }
})->group('validators');

test('check that app.css exist', function () {
    if (! file_exists('_site/media/app.css')) {
        $this->addWarning('Could not find the app stylesheet in the build directory. You may need to run `npm run dev`.');
    } else {
        $this->assertTrue(true);
    }
})->group('validators');
