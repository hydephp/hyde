<?php

namespace App\Commands;

use App\Hyde\Hyde;
use LaravelZero\Framework\Commands\Command;

class Publish404PageCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'publish:404 
                                {--type= : The view to publish. Must be Blade or Markdown }
                                {--force : Overwrite existing files}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Publish the 404 page';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $type = $this->option('type') ?? $this->choice(
            'Which type of view would you like to publish?',
            ['Blade', 'Markdown'],
            0
        );

        $type = strtolower($type);

        if (!in_array($type, ['blade', 'markdown'])) {
            $this->error('Type `'.$type.'` is not valid. It must be either `blade` or `markdown`');
            return 400;
        }
        
        if ($type === 'blade') {
            $source = Hyde::path('src/resources/stubs/404.blade.php');
            $path = Hyde::path('resources/views/pages/404.blade.php');
        }

        if ($type === 'markdown') {
            $source = Hyde::path('src/resources/stubs/404.md');
            $path = Hyde::path('_pages/404.md');
        }

        if (file_exists($path) && !$this->option('force')) {
            $this->error("File $path already exists!");
            return 409;
        }

        copy($source, $path);

        $this->info("Created file $path!");
        return 0;
    }
}
