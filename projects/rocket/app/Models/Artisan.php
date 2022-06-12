<?php

namespace Hyde\Rocket\Models;

/**
 * Proxies the HydeCLI Artisan interface.
 */
class Artisan
{
    protected string $path;

    public function __construct(string $absoluteProjectPath)
    {
        $this->path = $absoluteProjectPath;
    }

    /**
     * Run a command in the project's HydeCLI and return the output.
     */
    public function run(string $command): string
    {
        return shell_exec('cd '.$this->path.' && php hyde ' . $command);
    }

    /**
     * Run a command in the project's HydeCLI and stream the output.
     */
    public function passthru(string $command): void
    {
        passthru('cd '.$this->path.' && php hyde ' . $command);
    }
}
