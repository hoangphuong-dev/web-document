<?php

namespace App\Providers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class LoggingServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        DB::listen(function (QueryExecuted $query) {
            $sql  = $this->applyQueryBindings($query->sql, $query->bindings);
            $time = $query->time / 1000;

            if ($time >= 1.0 && Str::startsWith(strtolower($sql), 'select')) {
                $e = new \Exception("SLOW: {$time}s (SQL: {$sql})");
                Log::channel(make_channel_log('slow'))->info(format_log_message($e));
            } else {
                // Ghi not row effected log với query execute
                if (!Str::startsWith(strtolower($sql), ['select', '(select'])) {
                    $isModify = (function () {
                        return $this->recordsModified;
                    })(...)->call($query->connection);
                    if (!$isModify) {
                        $e = new \Exception("Execute not row effected: (SQL: {$sql})");
                        Log::channel(make_channel_log('daily'))->warning(format_log_message($e));
                    }
                }
            }
        });
    }

    public function boot(): void
    {
        // Phân loại log
        if ($this->app->runningInConsole()) {
            Log::setDefaultDriver('daily_cli');
        } else {
            Log::setDefaultDriver('daily_web');
        }
    }

    /**
     * Apply query bindings to the given SQL query.
     *
     * @param string $sql
     * @param array $bindings
     * @return string
     */
    private function applyQueryBindings(string $sql, array $bindings): string
    {
        $bindings = collect($bindings)->map(function ($binding) {
            return match (gettype($binding)) {
                'boolean' => (int)$binding,
                'string'  => "'{$binding}'",
                default   => $binding,
            };
        })->toArray();

        return Str::replaceArray('?', $bindings, $sql);
    }
}
