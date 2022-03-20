<?php

test('check that app.css exist', function () {
    if (!file_exists('_site/media/app.css')) {
        $this->addWarning('Could not find the app stylesheet in the build directory. You may need to run `npm run dev`.');  
    } else {
        $this->assertTrue(file_exists('_site/media/app.css'));
    }
})->group('validators');

test('check that tailwind.css exist', function () {
    if (!file_exists('_site/media/tailwind.css')) {
        $this->addWarning('Could not find the tailwind stylesheet in the build directory. You may need to run `npm run dev`.');  
    } else {
        $this->assertTrue(file_exists('_site/media/tailwind.css'));
    }
})->group('validators');
