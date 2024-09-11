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
        Schema::create('discounts', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Name of the discount
            
            $table->enum('type', ['percentage', 'fixed']); // Type of discount
            $table->decimal('value', 8, 2); // Discount value
            $table->date('start_date'); // Discount start date
            $table->date('end_date')->nullable(); // Discount end date, nullable for no end
            $table->unsignedBigInteger('product_id')->nullable(); // Associated product (optional)
            $table->unsignedBigInteger('collection_id')->nullable(); // Associated collection (optional)
            
            $table->timestamps();
        
            // Foreign key constraints
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->foreign('collection_id')->references('id')->on('collections')->onDelete('cascade');
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('discounts');
    }
};
