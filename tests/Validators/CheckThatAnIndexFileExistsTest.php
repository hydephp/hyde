<?php

use App\Hyde\Hyde;

test('check that an index file exists', function () {
     $assertion = file_exists(Hyde::path('_pages/index.md'))
               || file_exists(Hyde::path('resources/views/pages/index.blade.php'));

    if (!$assertion) {
        $this->addWarning('Could not find an index.md or index.blade.php file!'); 
    } else {
        $this->assertTrue($assertion);
    }
})->group('validators');
