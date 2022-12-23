<?php

declare(strict_types=1);

use Rector\Config\RectorConfig;
use Rector\Php80\Rector\Class_\ClassPropertyAssignToConstructorPromotionRector;
use Rector\Set\ValueObject\SetList;
use RectorLaravel\Set\LaravelSetList;

return static function (RectorConfig $rectorConfig): void {
    $rectorConfig->paths([__DIR__.'/packages/framework/src']);
    $rectorConfig->sets([
        LaravelSetList::LARAVEL_90,
        SetList::PHP_80,
        SetList::PHP_81,
    ]);

    $rectorConfig->skip([
        ClassPropertyAssignToConstructorPromotionRector::class,
    ]);
};
