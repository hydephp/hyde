<?php

use Hyde\Framework\Hyde;

test('check if a index page exists', function () {
    $assertion = file_exists(Hyde::path('_pages/index.md'))
    || file_exists(Hyde::path('_pages/index.blade.php'));

    if (! $assertion) {
        $this->addWarning('Could not find an index.md or index.blade.php file! You can publish the default one using `php hyde publish:views`');
    } else {
        $this->assertTrue(true);
    }
})->group('validators');
