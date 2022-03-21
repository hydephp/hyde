<?php

namespace App\Commands;

use App\Actions\Installer\Installer;
use App\Hyde\Hyde;
use LaravelZero\Framework\Commands\Command;

class Debug extends Command
{
    /**
     * The signature of the command.
     *
     * @var string
     */
    protected $signature = 'debug';

    /**
     * The description of the command.
     *
     * @var string
     */
    protected $description = 'Print debug info';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $this->info('HydePHP Debug Screen');

        $this->newLine();
        $this->line('Project directory:');
        $this->line(' > ' . Hyde::path());

        $this->newLine();

        $this->line('Enabled features:');
        foreach (config('hyde.features') as $feature) {
            $this->line(" - $feature");
        }

        return 0;
    }
}
