<?php

namespace Hyde\Rocket\Models;

/**
 * Abstraction for the current Hyde project.
 */
class Project
{
    protected static Project $instance;
    protected Hyde $hyde;
    protected Artisan $artisan;

    public string $path;
    public string $name;
    public string $version;

    protected function __construct()
    {
        $this->path = $this->getPathOrFail();
        $this->name = ucwords(basename($this->path));
        $this->hyde = new Hyde($this->path);
        $this->artisan = new Artisan($this->path);
        $this->version = $this->getVersion();
    }

    protected function getPathOrFail(): string
    {
        $path = realpath(getcwd() . '/../../');
        if (!is_dir($path)) {
            throw new \Exception("Not a directory.");
        }
        if (!is_file($path . '/hyde')) {
            throw new \Exception("Not a Hyde project.");
        }
        return $path;
    }

    public function hyde(): Hyde
    {
        return $this->hyde;
    }

    public function artisan(): Artisan
    {
        return $this->artisan;
    }

    /**
     * Get the project singleton instance, or, optionally,
     * specify a string to get that property from the instance.
     */
    public static function get(?string $property = null): mixed
    {
        if (!isset(static::$instance)) {
            static::$instance = new static();
        }

        return isset($property)
            ? static::$instance->$property
            : static::$instance;

    }

    protected function getVersion()
    {
        return json_decode(file_get_contents($this->path . '/composer.json'))->require->{'hyde/framework'};
    }
}
