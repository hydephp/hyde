<?php

namespace Hyde\Rocket\Models;

/**
 * Proxies the main Hyde facade.
 */
class Hyde extends \Hyde\Framework\Hyde
{
    public function __construct(string $absoluteProjectPath)
    {
        self::setBasePath($absoluteProjectPath);
    }
}
