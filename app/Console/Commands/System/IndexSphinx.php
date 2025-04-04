<?php

namespace App\Console\Commands\System;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class IndexSphinx extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sphinx:index';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        try {
            $output = shell_exec('sudo /usr/bin/indexer --config /etc/sphinxsearch/sphinx.conf --all --rotate');

            Log::info('Sphinx indexer output: ' . $output);

            $this->info('Sphinx indexer ran successfully.');
        } catch (\Exception $e) {
            Log::error('Error running sphinx indexer: ' . $e->getMessage());
            $this->error('Failed to run sphinx indexer.');
        }
    }
}
