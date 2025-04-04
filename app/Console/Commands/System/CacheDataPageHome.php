<?php

namespace App\Console\Commands\System;

use App\Jobs\System\CacheDataPageHomeJob;
use Illuminate\Console\Command;

class CacheDataPageHome extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vn:cache-data-page-home
    {--f|force : Force}
    ';

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
        $force = $this->option('force');
        $force ? (new CacheDataPageHomeJob())->handle() : CacheDataPageHomeJob::dispatch();
    }
}
