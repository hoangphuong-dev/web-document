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
        Schema::table('document_meta_data', function (Blueprint $table) {
            $table->string('ai_tag')->nullable();
            $table->string('ai_topic')->nullable();
            $table->string('list_related_id')->nullable();
            $table->timestamp('list_related_time')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('document_meta_data', function (Blueprint $table) {
            $table->dropColumn('ai_tag');
            $table->dropColumn('ai_topic');
            $table->dropColumn('list_related_id');
            $table->dropColumn('list_related_time');
        });
    }
};
