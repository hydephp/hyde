<?php

namespace App\Core\Actions;

use App\Core\Hyde;
use JetBrains\PhpStorm\Pure;

class CreatesDefaultDirectories
{
    protected array $requiredDirectories = [
        '_drafts',
        '_pages',
        '_posts',
        '_media',
        '_site',
        '_docs',
        '_site/posts',
        '_site/media',
        '_site/docs',
    ];

    public function __invoke(): void
    {
        foreach ($this->requiredDirectories as $directory) {
            // Does the directory exist?     // Otherwise, create it.
            is_dir(Hyde::path($directory)) || mkdir(Hyde::path($directory));
        }
    }

    #[Pure] public static function getRequiredDirectories(): array
    {
        return (new CreatesDefaultDirectories)->requiredDirectories;
    }
}
