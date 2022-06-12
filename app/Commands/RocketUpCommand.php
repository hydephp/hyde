<?php

namespace App\Commands;

use Hyde\Framework\Hyde;
use LaravelZero\Framework\Commands\Command;

class RocketUpCommand extends Command
{
    protected $signature = 'rocket:up';

    public function handle()
    {
        $this->line('<fg=blue>Launching Rocket!</> Press Ctrl+C to stop');
        $this->warn('Rocket is an experimental development tool that must never be installed on production servers!');
        passthru('php -S localhost:3000 -t rocket/public');
    }
}
