<?php

namespace App\Actions;

use JetBrains\PhpStorm\Pure;

class CreatesDefaultDirectories
{
    protected array $requiredDirectories = [
        '_drafts',
        '_pages',
        '_posts',
        '_site',
        '_site/posts',
    ];

    public function __invoke(): void
    {
        foreach ($this->requiredDirectories as $directory) {
            // Does the directory exist?     // Otherwise, create it.
            realpath("./$directory") || mkdir(realpath('.') . "/$directory");
        }
    }

    #[Pure] public static function getRequiredDirectories(): array
    {
        return (new CreatesDefaultDirectories)->requiredDirectories;
    }
}
