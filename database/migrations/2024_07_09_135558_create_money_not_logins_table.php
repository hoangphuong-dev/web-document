<?php

use App\Enums\Payment\DeviceType;
use App\Enums\Payment\NotLogin\MoneyStatus;
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
        Schema::create('money_not_logins', function (Blueprint $table) {
            $table->id();
            $table->string('guest_id')->nullable();
            $table->integer('document_id');
            $table->string('order_id')->nullable()->comment('Mã giao dịch khi request giao dịch đến cổng thanh toán');
            $table->string('transaction_id')->nullable()->comment('	Mã giao dịch khi cổng thanh toán trả kết quả');
            $table->integer('money_need');
            $table->integer('money')->default(0);
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->ipAddress('ip');
            $table->string('device_type')->nullable()->comment(DeviceType::class);
            $table->string('description')->nullable();
            $table->string('status')->comment(MoneyStatus::class)->default(MoneyStatus::PENDDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('money_not_logins');
    }
};
