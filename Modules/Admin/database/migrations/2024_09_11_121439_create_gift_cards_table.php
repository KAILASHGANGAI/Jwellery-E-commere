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
        Schema::create('gift_cards', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the gift
            $table->string('code'); // Unique code for the gift
            $table->date('expiry_date')->nullable(); // Expiry date of the gift
            $table->text('description')->nullable(); // Description of the gift
            $table->decimal('value', 8, 2)->nullable(); // Value of the gift, if any
            $table->unsignedBigInteger('product_id')->nullable(); // Gift associated with a product (optional)
            $table->unsignedBigInteger('collection_id')->nullable(); // Gift associated with a collection (optional)
            $table->unsignedBigInteger('customer_id')->nullable(); // Gift associated with a specific customer (optional)
            $table->string('status')->default('archived');
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
            $table->foreign('customer_id')->references('id')->on('customers')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gift_cards');
    }
};
