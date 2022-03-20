<?php

test('there are no conflicts between blade and markdown pages', function () {
    $markdownPages = [];
    $bladePages = [];

    foreach (array_diff(scandir('_pages'), array('..', '.')) as $page) {
        $markdownPages[] = basename($page, '.md');
    }

    foreach (array_diff(scandir('resources/views/pages'), array('..', '.')) as $page) {
        $bladePages[] = basename($page, '.blade.php');
    }

    $conflicts = array_intersect($markdownPages, $bladePages);
    expect($conflicts)->toBeEmpty();
})->group('validators');
