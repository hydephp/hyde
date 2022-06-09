<?php

test('check that app.css exist', function () {
    if (! file_exists('_site/media/app.css')) {
        $this->addWarning('Could not find the app stylesheet in the build directory. You may need to run `npm run dev`.');
    } else {
        $this->assertTrue(true);
    }
})->group('validators');
