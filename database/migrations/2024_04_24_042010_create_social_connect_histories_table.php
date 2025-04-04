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
        Schema::create('social_connect_histories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('provider')->comment('facebook, google, zalo, ...');
            $table->string('provider_id');
            $table->tinyInteger('type_connect')->comment('0: Unconnect, 1: Connect, 2: Admin unconnect, 3 Admin connect');
            $table->timestamps();

            $table->index(['user_id', 'provider_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('social_connect_histories');
    }
};
