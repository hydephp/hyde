<?php

namespace App\Core;

/**
 * General interface for Hyde services
 */
class Hyde
{
    /**
     * Is Torchlight enabled?
     *
     * Torchlight is an API for Syntax Highlighting. By default, it is enabled
     * automatically when an API token is set in the .env file.
     * @return bool
     */
    public static function hasTorchlight(): bool
    {
        return (config('torchlight.token') !== null);
    }

    /**
     * Return the path where the Blade views are located
     * @return string
     */
    public static function viewPath()
    {
        return resource_path('views') ;
    }

    /**
     * Get an absolute path from a supplied relative path.
     *
     * The function returns the fully qualified path to your site's root directory.
     *
     * You may also use the function to generate a fully qualified path to a given file
     * relative to the project root directory when supplying the path argument.
     *
     * @param string $path
     * @return string
     */
    public static function path(string $path = ''): string
    {
        if (empty($path)) {
            return getcwd();
        }

        $path = trim($path, '/\\');

        return getcwd() . DIRECTORY_SEPARATOR . $path;
    }
}
