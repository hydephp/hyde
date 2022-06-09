<?php

use Illuminate\Contracts\Console\Kernel;

beforeEach(function () {
    $app = require __DIR__.'/../../bootstrap/app.php';

    $app->make(Kernel::class)->bootstrap();

    return $app;
});

test('check if site url is set', function () {
    $assertion = (bool) Hyde::uriPath();
    if (! $assertion) {
        $this->addWarning('Did not find a Site URL in .env. Adding it may improve SEO.');
    } else {
        $this->assertTrue(true);
    }
})->group('validators');
