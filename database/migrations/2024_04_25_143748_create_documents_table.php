<?php

use App\Enums\ActiveStatus;
use App\Enums\Document\ConvertStatus;
use App\Enums\Document\DocumentExt;
use App\Enums\Document\DocumentStatus;
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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->text('title');
            $table->text('slug');
            $table->string('file_name');
            $table->string('path');
            $table->ipAddress('uploaded_ip');
            $table->unsignedBigInteger('owner_id')->index();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->unsignedInteger('file_size')->default(0);
            $table->integer('ext')->comment(DocumentExt::class);
            $table->integer('status')->comment(DocumentStatus::class);
            $table->integer('convert_status')
                ->default(ConvertStatus::INIT)
                ->comment(ConvertStatus::class);
            $table->integer('active')->comment(ActiveStatus::class);
            $table->timestamp('admin_active_date')->nullable();
            $table->unsignedInteger('money_sale')->default(0);
            $table->unsignedInteger('number_page')->default(0);
            $table->unsignedBigInteger('number_view')->default(0);
            $table->unsignedBigInteger('number_download')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
