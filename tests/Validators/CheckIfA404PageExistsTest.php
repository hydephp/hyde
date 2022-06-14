<?php

use Hyde\Framework\Hyde;

test('check if a 404 page exists', function () {
    $assertion = file_exists(Hyde::path('_pages/404.md'))
    || file_exists(Hyde::path('_pages/404.blade.php'));

    if (! $assertion) {
        $this->addWarning('Could not find an 404.md or 404.blade.php file! You can publish the default one using `php hyde publish:views`');
    } else {
        $this->assertTrue(true);
    }
})->group('validators');
