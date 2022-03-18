<?php

namespace App\Actions\Installer;

/**
 * The App Installer class methods
 */
class Installer
{
    public static function isInstalled(): bool
    {
        return is_dir('resources');
    }
}
