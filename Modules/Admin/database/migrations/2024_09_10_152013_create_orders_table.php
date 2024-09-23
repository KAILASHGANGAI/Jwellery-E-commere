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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->unsignedBigInteger('customer_id')->nullable();
            $table->string('orderNumber')->nullable();
            $table->string('status')->default('pending');
            $table->decimal('total_amount', 8, 2);
            $table->integer('no_of_item')->default(1);
            $table->decimal('subtotal', 8, 2)->nullable();
            $table->decimal('delivaryCharge', 8, 2)->nullable();
            $table->string('payment_method')->nullable();
            $table->decimal('nettotal', 8, 2)->nullable();
            $table->decimal('discount', 8, 2)->nullable();
            $table->string('coupon_code')->nullable();
            $table->date('order_date');
            $table->date('delivary_date')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
