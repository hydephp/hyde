<?php

namespace App\Commands;

use App\Hyde\Actions\GetMarkdownPostList;
use App\Hyde\MarkdownPostParser;
use App\Hyde\MarkdownPageParser;
use App\Hyde\Models\BladePage;
use App\Hyde\Models\MarkdownPage;
use App\Hyde\StaticPageBuilder;
use Illuminate\Console\Scheduling\Schedule;
use LaravelZero\Framework\Commands\Command;

class BuildStaticSiteCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'build';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Build the static site';

    /**
     * Execute the console command.
     *
     * @return int
     * @throws \Exception
     */
    public function handle(): int
    {
        $this->title('Building your static site!');

        $this->line('Creating Markdown Posts...');
        $this->withProgressBar((array_flip((new GetMarkdownPostList)->execute())), function ($post) {
            (new StaticPageBuilder((new MarkdownPostParser($post))->get(), true));
        });

        $this->newLine(2);
        $this->line('Creating Markdown Pages...');
        $this->withProgressBar(array_flip(MarkdownPage::allAsArray()), function ($page) {
            (new StaticPageBuilder((new MarkdownPageParser($page))->get(), true));
        });

        $this->newLine(2);
        $this->line('Creating Blade Pages...');
        $this->withProgressBar(glob(base_path('resources/views/pages/*.blade.php')), function ($filepath) {
            (new StaticPageBuilder((new BladePage(basename($filepath, '.blade.php'))), true));
        });

        $this->newLine(2);
        $this->info('All done!');
        return 0;
    }
}
