<?php

namespace App\Commands;

use Exception;
use LaravelZero\Framework\Commands\Command;
use App\Core\Services\CollectionService;
use App\Core\DocumentationPageParser;
use App\Core\Features;
use App\Core\Hyde;
use App\Core\MarkdownPostParser;
use App\Core\MarkdownPageParser;
use App\Core\StaticPageBuilder;
use App\Core\Models\BladePage;
use App\Core\Models\MarkdownPage;
use App\Core\Models\MarkdownPost;
use App\Core\Models\DocumentationPage;

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

        $this->line('Transferring Media Assets...');
        $this->withProgressBar(
            glob(Hyde::path('_media/*.{png,svg,jpg,jpeg,gif,ico}'), GLOB_BRACE),
            function ($filepath) {
                if ($this->getOutput()->isVeryVerbose()) {
                    $this->line(' > Copying media file '
                    . basename($filepath). ' to the output media directory');
                }

                copy($filepath, Hyde::path('_site/media/'. basename($filepath)));
            }
        );

        if (Features::hasBlogPosts()) {
            $this->newLine(2);
            $this->line('Creating Markdown Posts...');
            $this->withProgressBar(
                CollectionService::getSourceSlugsOfModels(MarkdownPost::class),
                function ($slug) {
                    $this->debug((new StaticPageBuilder((new MarkdownPostParser($slug))->get(), true))
                    ->getDebugOutput());
                }
            );
        }

        if (Features::hasMarkdownPages()) {
            $this->newLine(2);
            $this->line('Creating Markdown Pages...');
            $this->withProgressBar(
                CollectionService::getSourceSlugsOfModels(MarkdownPage::class),
                function ($slug) {
                    $this->debug((new StaticPageBuilder((new MarkdownPageParser($slug))->get(), true))
                        ->getDebugOutput());
                }
            );
        }

        if (Features::hasDocumentationPages()) {
            $this->newLine(2);
            $this->line('Creating Documentation Pages...');
            $this->withProgressBar(
                CollectionService::getSourceSlugsOfModels(DocumentationPage::class),
                function ($slug) {
                    $this->debug((new StaticPageBuilder((new DocumentationPageParser($slug))->get(), true))
                    ->getDebugOutput());
                }
            );
        }

        if (Features::hasBladePages()) {
            $this->newLine(2);
            $this->line('Creating Blade Pages...');
            $this->withProgressBar(CollectionService::getSourceSlugsOfModels(BladePage::class), function ($slug) {
                $this->debug((new StaticPageBuilder((new BladePage($slug)), true))->getDebugOutput());
            });
        }

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
        echo(
            "Your new homepage is stored here -> file://" . str_replace(
                '\\',
                '/',
                realpath(Hyde::path('_site/index.html'))
            )
        );

        return 0;
    }
}
