<?php

error_reporting(E_ALL);
$time = microtime(true);

// Generate some file fixtures for quick visual testing.

use Hyde\Framework\Actions\CreatesNewPageSourceFile;
use Hyde\Framework\Models\Pages\BladePage;
use Hyde\Framework\Models\Pages\DocumentationPage;
use Hyde\Framework\Models\Pages\MarkdownPage;

$autoloader = require __DIR__.'/../../vendor/autoload.php';
$app = require_once __DIR__.'/../../app/bootstrap.php';

foreach (['Index', 'Page 1', 'Page 2', 'Page 3'] as $page) {
    file_put_contents((new CreatesNewPageSourceFile($page, DocumentationPage::class, true))->outputPath,
        file_get_contents('markdown.md'),
        FILE_APPEND
    );
}

file_put_contents((new CreatesNewPageSourceFile('Markdown Page', MarkdownPage::class, true))->outputPath,
    file_get_contents('markdown.md'),
    FILE_APPEND
);

(new CreatesNewPageSourceFile('Blade Page', BladePage::class, true));

echo 'Finished in '.round((microtime(true) - $time) * 1000, 2).'ms';
