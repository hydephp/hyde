<?php

namespace App\Commands;

use Exception;
use LaravelZero\Framework\Commands\Command;
use App\Hyde\Services\CollectionService;
use App\Hyde\DocumentationPageParser;
use App\Hyde\MarkdownPostParser;
use App\Hyde\MarkdownPageParser;
use App\Hyde\StaticPageBuilder;
use App\Hyde\Models\BladePage;
use App\Hyde\Models\MarkdownPage;
use App\Hyde\Models\MarkdownPost;
use App\Hyde\Models\DocumentationPage;

class BuildStaticSiteCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'build {--pretty : Should the build files be prettified?}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Build the static site';


    private function debug(array $output)
    {
        if ($this->getOutput()->isVeryVerbose()) {
            $this->newLine();
            $this->line("<fg=gray>Created {$output['createdFileSize']} byte file {$output['createdFilePath']}</>");
            $this->newLine();
        }
    }

    /**
     * Execute the console command.
     *
     * @return int
     * @throws Exception
     */
    public function handle(): int
    {
        $time_start = microtime(true);

        $this->title('Building your static site!');

        if ($this->getOutput()->isVeryVerbose()) {
            $this->warn('Running with high verbosity');
        }

        $this->line('Creating Markdown Posts...');
        $this->withProgressBar(CollectionService::getSourceSlugsOfModels(MarkdownPost::class), function ($slug) {
            $this->debug((new StaticPageBuilder((new MarkdownPostParser($slug))->get(), true))->getDebugOutput());
        });

        $this->newLine(2);
        $this->line('Creating Markdown Pages...');
        $this->withProgressBar(CollectionService::getSourceSlugsOfModels(MarkdownPage::class), function ($slug) {
            $this->debug((new StaticPageBuilder((new MarkdownPageParser($slug))->get(), true))->getDebugOutput());
        });

        $this->newLine(2);
        $this->line('Creating Documentation Pages...');
        $this->withProgressBar(CollectionService::getSourceSlugsOfModels(DocumentationPage::class), function ($slug) {
            $this->debug((new StaticPageBuilder((new DocumentationPageParser($slug))->get(), true))->getDebugOutput());
        });

        $this->newLine(2);
        $this->line('Creating Blade Pages...');
        $this->withProgressBar(CollectionService::getSourceSlugsOfModels(BladePage::class), function ($slug) {
            $this->debug((new StaticPageBuilder((new BladePage($slug)), true))->getDebugOutput());
        });

        $this->newLine(2);

        if ($this->option('pretty')) {
            $this->info('Prettifying code! This may take a second.');
            try {
                $this->line(shell_exec('npx prettier _site/ --write'));
            } catch (Exception) {
                $this->warn('Could not prettify code! Is NPM installed?');
            }
        }

        $time_end = microtime(true);
        $execution_time = ($time_end - $time_start);
        $this->info('All done! Finished in ' . number_format(
            $execution_time,
            2
        ) .' seconds. (' . number_format(($execution_time * 1000), 2) . 'ms)');

        $this->info('Congratulations! 🎉 Your static site has been built!');
        $this->info(sprintf(
            "Your new homepage is stored here -> %s",
            base_path('_site' . DIRECTORY_SEPARATOR . 'index.html')
        ));

        return 0;
    }
}
