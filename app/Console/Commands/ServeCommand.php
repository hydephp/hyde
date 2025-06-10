<?php

namespace App\Console\Commands;

use App\Services\ViteService;
use Hyde\Console\Commands\ServeCommand as BaseServeCommand;
use RuntimeException;
use Symfony\Component\Process\Process;

class ServeCommand extends BaseServeCommand
{
    /**
     * The Vite development server process.
     */
    protected ?Process $viteProcess = null;

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if ($this->option('vite')) {
            try {
                ViteService::ensureViteCanRun($this);
                $this->info('Starting Vite development server...');
                $this->viteProcess = ViteService::startViteServer();
            } catch (RuntimeException $e) {
                $this->error($e->getMessage());
                return 1;
            }
        }

        return parent::handle();
    }

    /**
     * {@inheritDoc}
     */
    public function __destruct()
    {
        if ($this->viteProcess !== null) {
            $this->viteProcess->stop();
        }

        parent::__destruct();
    }
}
