<?php

namespace App\Commands;

use Hyde\Framework\Hyde;
use Illuminate\Support\Facades\File;
use LaravelZero\Framework\Commands\Command;

/**
 * Backs up source files, runs tests, then restores original files.
 */
class TestWithBackup extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'test:safe';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Run tests without affecting source files';

    /**
     * The directories to backup.
     * 
     * @var array
     */
    protected $directories = [
        '_pages',
        '_posts',
        '_media',
        '_docs',
        '_site',
        'config',
        'resources',
    ];

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->warn('This command is experimental and may not work properly and is not a replacement for backups!');
        $this->line('Please use with caution and report any issues.');

        $this->info('Backing up source files...');
        $this->backup();

        $this->info('Running tests...');
        $this->call('test');

        $this->info('Restoring source files...');
        $this->restore();
    }

    /**
     * Backup the source files.
     *
     * @return void
     */
    protected function backup()
    {
        foreach ($this->directories as $directory) {
            static::backupDirectory(Hyde::path($directory));
        }
    }

    /**
     * Restore the source files.
     *
     * @return void
     */
    protected function restore()
    {
        foreach ($this->directories as $directory) {
            static::restoreDirectory(Hyde::path($directory));
        }
    }
    
    public static function backupDirectory(string $directory)
    {
        if (file_exists($directory)) {
            File::copyDirectory($directory, $directory.'-bak', true);
        }
    }
    
    public static function restoreDirectory(string $directory)
    {
        if (file_exists($directory.'-bak')) {
            File::moveDirectory($directory.'-bak', $directory, true);
            File::deleteDirectory($directory.'-bak');
        }
    }
    
}
