<?php

namespace App\Commands;

use Exception;
use LaravelZero\Framework\Commands\Command;
use App\Hyde\Services\CollectionService;
use App\Hyde\DocumentationPageParser;
use App\Hyde\Features;
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

        if (Features::hasBlogPosts()) {
            $this->line('Creating Markdown Posts...');
            $this->withProgressBar(CollectionService::getSourceSlugsOfModels(MarkdownPost::class), function ($slug) {
                $this->debug((new StaticPageBuilder((new MarkdownPostParser($slug))->get(), true))->getDebugOutput());
            });
        }

        if (Features::hasMarkdownPages()) {
            $this->newLine(2);
            $this->line('Creating Markdown Pages...');
            $this->withProgressBar(CollectionService::getSourceSlugsOfModels(MarkdownPage::class), function ($slug) {
                $this->debug((new StaticPageBuilder((new MarkdownPageParser($slug))->get(), true))->getDebugOutput());
            });
        }

        if (Features::hasDocumentationPages()) {
            $this->newLine(2);
            $this->line('Creating Documentation Pages...');
            $this->withProgressBar(CollectionService::getSourceSlugsOfModels(DocumentationPage::class), function ($slug) {
                $this->debug((new StaticPageBuilder((new DocumentationPageParser($slug))->get(), true))->getDebugOutput());
            });
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
        $this->info(sprintf(
            "Your new homepage is stored here -> %s",
            base_path('_site' . DIRECTORY_SEPARATOR . 'index.html')
        ));

        if (($this->option('no-ansi') && !file_exists('_site/media/app.css'))) {
            $this->warn('Could not find the app stylesheet in the build directory. You may need to run `npm run dev`.');
        }

        if (Features::hasDocumentationPages()) {
            if (!file_exists('_docs/index.md') && !file_exists('_site/docs/index.html')) {
                $this->newLine();
                $docIndexMissingMessage = 'Could not find an index.md file in the _docs directory. ';
                // @todo add case-sensitivity support to allow both readme.md and README.md on UNIX system
                if (file_exists('_docs/readme.md')) {
                    $docIndexMissingMessage .= 'However, a readme.md file was found.';
                    $this->warn($docIndexMissingMessage);
                        $this->line($this->option('no-interaction')
                        ? 'You can re-run this command without the --no-interaction flag to copy it to index.md. '
                        : 'Would you like to copy it to index.md?');
                        if ($this->choice('Create _docs/index.md from _docs/readme.md?',
                                ['Yes', 'No'],
                                0) == 'Yes') {
                            $this->line('Okay, creating the file!');
                            try {
                                copy('_docs/readme.md', '_docs/index.md');
                                $this->debug((new StaticPageBuilder((new DocumentationPageParser('index'))->get(),
                                    true))->getDebugOutput());
                                $this->line('Created _docs/index.md and _site/docs/index.html!');
                            } catch (Exception $exception) {
                                $this->error('Something went wrong when trying to save the file!');
                                $this->warn($exception->getMessage());
                                return $exception->getCode() ?? 1;
                            }
                        } else {
                            $this->line('Alright. You can always rerun this command or create it manually!');
                        }

                } else {
                    $docIndexMissingMessage .= 'You may want to create one. ';
                    $this->warn($docIndexMissingMessage);
                }
            }
        }

        return 0;
    }
}
