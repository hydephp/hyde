<?php

namespace App\Commands;

use App\Hyde\Features;
use Exception;
use LaravelZero\Framework\Commands\Command;
use Illuminate\Support\Str;

/**
 * @deprecated see issue #16
 */
class MakeNavigationLinkCommand extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'make:navigation-link';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Create an arbitrary navigation link';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->warn('This command is deprecated and will be removed as it becomes unnecessary when issue #16 is implemented.');

        if (!Features::hasBladePages()) {
            $this->warn('This feature requires BladePages to be enabled in config/hyde.php');
            return 1;
        }

        $this->info('Creating a new navigation link!');
        $this->line('Tip: Navigation links are automatically created for Blade and Markdown pages!');

        $title = $this->ask('What is the title of the navigation link?', 'Docs');

        $type = $this->choice(
            'What kind of link do you want to create?',
            ['Relative', 'External'],
            0
        );

        $destination = $this->ask('Where should the link lead to?',
            ($type == 'Relative') ? 'docs/index.html' : 'https://laravel.com/docs/');
        $this->line(($type == 'Relative')
            ? 'Please enter a relative path'
            : 'Please enter a full URI including https://');

        $this->info("Creating an $type link named $title leading to $destination");
        if ($this->confirm('Do you wish to continue?', true)) {
            try {
                $filename = Str::slug($title);
                $path = "resources/views/pages/$filename.blade.php";
                if (file_exists($path)) {
                    throw new Exception("File $path already exists!", 409);
                }
                if (file_put_contents($path, <<<EOF
<!-- Neat hack to create custom navigation menu links -->
<meta http-equiv="refresh" content="0; URL=$destination" />

EOF
)) {
                $this->line("Created navigation link $title with redirect file $path ");
            } else {
                    throw new Exception('File was not saved');
                }
            } catch (Exception $exception) {
                $this->error('Something went wrong when trying to save the file!');
                $this->warn($exception->getMessage());
                return $exception->getCode() ?? 1;
            }
        } else {
            $this->warn('Aborting.');
            return 0;
        }
        return 0;
    }
}
