<?php

if (file_exists('_pages')) {
    test('check for conflicts between blade and markdown pages', function () {
        $markdownPages = [];
        $bladePages = [];

        foreach (array_diff(scandir('_pages'), ['..', '.']) as $page) {
            $markdownPages[] = basename($page, '.md');
        }

        foreach (array_diff(scandir('_pages'), ['..', '.']) as $page) {
            $bladePages[] = basename($page, '.blade.php');
        }

        $conflicts = array_intersect($markdownPages, $bladePages);

        if (count($conflicts)) {
            $this->addWarning('Found conflicts: '.implode(', ', $conflicts));
        } else {
            expect($conflicts)->toBeEmpty();
        }
    })->group('validators');
}
