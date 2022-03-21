<?php

namespace App\Commands;

use Hyde\Core\Hyde;
use LaravelZero\Framework\Commands\Command;

class Validate extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'validate';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Run a series of tests to validate your setup and help you optimize your site.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Running validation tests!');

        $this->line(shell_exec(Hyde::path('vendor/bin/pest') . ' --group=validators'));

        $this->info('All done!');
    }
}
