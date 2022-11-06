<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Laravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([__DIR__.'/packages/framework/src']);
    $rectorConfig->sets([
        LaravelSetList::LARAVEL_90,
        \Rector\Set\ValueObject\SetList::PHP_80,
        \Rector\Set\ValueObject\SetList::PHP_81,
    ]);
};
