<?php

test('check if a 404 page exists', function () {
    $assertion = file_exists(realpath('_pages/404.md'))
    || file_exists(realpath('resources/views/pages/404.blade.php'));

    if (!$assertion) {
    $this->addWarning('Could not find an 404.md or 404.blade.php file! You can scaffold one using `php hyde publish:404`'); 
    } else {
    $this->assertTrue($assertion);
    }
})->group('validators');
