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
        Schema::create('url_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->integer('tokenable_id');
            $table->string('url');
            $table->string('token')->unique();
            $table->integer('number_used');
            $table->timestamp('expired_at');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('url_access_tokens');
    }
};
