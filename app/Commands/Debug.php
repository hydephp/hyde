<?php

namespace App\Commands;

use App\Actions\Installer\Installer;
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

        $this->line('Enabled features:');
        foreach (config('hyde.features') as $feature) {
            $this->line(" - $feature");
        }

        $this->line('Environment check:');
        $this->line(" - Is app installed? " . (Installer::isInstalled() ? 'True' : 'False'));

        return 0;
    }
}
