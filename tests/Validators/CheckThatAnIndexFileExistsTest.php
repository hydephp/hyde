<?php

test('check that an index file exists', function () {
     $assertion = file_exists(realpath('_pages/index.md'))
               || file_exists(realpath('resources/views/pages/index.blade.php'));

    if (!$assertion) {
        $this->addWarning('Could not find an index.md or index.blade.php file!'); 
    } else {
        $this->assertTrue($assertion);
    }
})->group('validators');
