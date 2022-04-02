<?php

use Hyde\Framework\Features;
use Illuminate\Contracts\Console\Kernel;

beforeEach(function () {
    $app = require __DIR__.'/../../bootstrap/app.php';

    $app->make(Kernel::class)->bootstrap();

    return $app;
});

test('check that documentation pages have an index page', function () {
    if (! Features::hasDocumentationPages()) {
        $this->markTestSkipped('Documentation page feature is disabled in config');
    }

    $indexFileExists = file_exists('_docs/index.md');
    $readmeFileExists = (file_exists('_docs/index.md') || (file_exists('_docs/README.md')));

    $message = 'Could not find an index.md file in the _docs directory!';
    if ($readmeFileExists) {
        $message .= ' However, a _docs/readme.md file was found. A suggestion would be to copy the _docs/readme.md to _docs/index.md.';
    }

    if (! $indexFileExists) {
        $this->addWarning($message);
    } else {
        $this->assertTrue(true);
    }
})->group('validators');
