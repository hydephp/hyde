<?php

namespace App\Commands;

use Hyde\Core\Actions\CreatesNewMarkdownPostFile;
use Exception;
use LaravelZero\Framework\Commands\Command;

class MakePostCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:post
                            {--force : Should the generated file overwrite existing posts with the same slug?}';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Scaffold a new Markdown blog post file';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->title('Creating a new post!');

        $this->line('Please enter the title of the post, it will be used to generate the slug.');
        $title = $this->ask('What is the title of the post?') ?? 'My New Post';

        $this->line('Tip: You can just hit return to use the defaults.');
        $description = $this->ask('Write a short post excerpt/description');
        $author      = $this->ask('What is your (the author\'s) name?');
        $category    = $this->ask('What is the primary category of the post?');

        $this->info('Creating a post with the following details:');
        $creator = new CreatesNewMarkdownPostFile(
            title: $title,
            description: $description,
            category: $category,
            author: $author
        );

        $this->line("Title: $creator->title");
        $this->line("Description: $creator->description");
        $this->line("Author: $creator->author");
        $this->line("Category: $creator->category");
        $this->line("Date: $creator->date");
        $this->line("Slug: $creator->slug");

        if (!$this->confirm('Do you wish to continue?', true)) {
             $this->info('Aborting.');
             return 0;
        }

        try {
            if ($path = $creator->save($this->option('force'))) {
                $this->info("Post created! File is saved to $path");
                return 0;
            } else {
                $this->error('Something went wrong when trying to save the file!');
                return 1;
            }
        } catch (Exception $exception) {
            $this->error('Something went wrong when trying to save the file!');
            $this->warn($exception->getMessage());
            if ($exception->getCode() === 409) {
                $this->comment('If you want to overwrite the file supply the --force flag.');
                return 409;
            }
            return 1;
        }
    }
}
