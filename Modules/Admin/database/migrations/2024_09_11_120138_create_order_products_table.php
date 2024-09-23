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
        Schema::create('order_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('variation_id')->nullable();
            $table->unsignedBigInteger('vendor_id')->nullable();
            $table->string('sku')->nullable();
            $table->string('barcode')->nullable();
            $table->string('color')->nullable();
            $table->string('option1')->nullable();
            $table->string('option2')->nullable();
            $table->integer('quantity')->default(1);
            $table->decimal('unitPrice', 8, 2);
            $table->decimal('subtotal', 8, 2);
            $table->string('status')->default('pending');
            $table->string('discount_amount')->default(0);
            $table->string('tax_amount')->default(0);
            $table->string('shipping_charge')->default(0);
            $table->string('discountCode')->default(0);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_products');
    }
};
