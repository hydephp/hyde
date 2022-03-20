<?php

test('check that an index file exists', function () {
    $this->assertTrue(
        file_exists(realpath('_pages/index.md'))
        || file_exists(realpath('resources/views/pages/index.blade.php'))
    );
})->group('validators');
