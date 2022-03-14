<?php

namespace App\Actions;

class CreatesDefaultDirectories
{
    protected array $requiredDirectories = [
        '_drafts',
        '_pages',
        '_posts',
        '_site',
    ];

    public function __invoke(): void
    {
        foreach ($this->requiredDirectories as $directory) {
            // Does the directory exist?     // Otherwise, create it.
            realpath("./$directory") || mkdir(realpath('.') . "/$directory");
        }
    }

    public static function getRequiredDirectories(): array
    {
        return (new CreatesDefaultDirectories)->requiredDirectories;
    }
}
