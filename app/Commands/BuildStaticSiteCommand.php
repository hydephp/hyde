<?php

namespace App\Commands;

use App\Hyde\Actions\GetMarkdownPostList;
use App\Hyde\MarkdownPostParser;
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

        $this->line('Creating posts...');
        $this->withProgressBar((array_flip((new GetMarkdownPostList)->execute())), function ($post) {
            (new StaticPageBuilder((new MarkdownPostParser($post))->get(), true));
        });

        $this->newLine(2);
        $this->info('All done!');
        return 0;
    }
}
