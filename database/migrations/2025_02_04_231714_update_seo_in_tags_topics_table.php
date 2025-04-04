<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->string('ai_title')->nullable();
            $table->string('ai_description')->nullable();
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->string('ai_title')->nullable();
            $table->string('ai_description')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tags', function (Blueprint $table) {
            $table->dropColumn('ai_title');
            $table->dropColumn('ai_description');
        });

        Schema::table('topics', function (Blueprint $table) {
            $table->dropColumn('ai_title');
            $table->dropColumn('ai_description');
        });
    }
};
