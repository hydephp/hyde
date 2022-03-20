<?php

test('check that frontend assets exist', function () {
    $this->assertTrue(file_exists('_site/media/app.css'), "\033[33mCould not find the app stylesheet in the build directory. You may need to run `npm run dev`.\033[0m");
    $this->assertTrue(file_exists('_site/media/tailwind.css'), "\033[33mCould not find the tailwind stylesheet in the build directory. You may need to run `npm run dev`.\033[0m");
})->group('validators');
