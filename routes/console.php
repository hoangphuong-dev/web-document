<?php

use Illuminate\Support\Facades\Schedule;

// Schedule::command('onelib:update-summary --limit=20 --queue')->hourly();

// Gen sitemap
// Schedule::command('sitemap:documents')->everySixHours();

// Cache data page home
// Schedule::command('vn:cache-data-page-home')->dailyAt('01:00');

// Index search engine
Schedule::command('sphinx:index')->dailyAt('02:00');

// Đồng bộ ai_topic cho metadata
// Schedule::command('vn:sync-ai-topic')->dailyAt('03:00');

// Đồng bộ ai_tag cho metadata
// Schedule::command('vn:sync-ai-tag')->dailyAt('04:00');

// Cập nhật tài liệu liên quan 
// Schedule::command('vn:update-related-document')->everyFiveMinutes();
