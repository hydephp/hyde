<?php

namespace App\Hyde;

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
}
