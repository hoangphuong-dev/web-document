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
        Schema::create('document_meta_data', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id')->unique();
            $table->string('ai_title')->nullable();
            $table->string('ai_description')->nullable();
            $table->string('ai_heading')->nullable();
            $table->text('ai_summary')->nullable();
            $table->text('ai_cover')->nullable();
            $table->text('ai_topical')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_meta_data');
    }
};
