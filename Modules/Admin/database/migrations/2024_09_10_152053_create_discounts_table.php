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
            
            $table->enum('type', ['percentage', 'fixed']); 
            $table->decimal('value', 8, 2); 
            $table->date('start_date'); 
            $table->date('end_date')->nullable(); 
            $table->string('discount_on')->nullable();
            $table->text('product_ids')->nullable(); 
            $table->text('collection_ids')->nullable(); 
            $table->enum('status', ['active', 'archived'])->default('archived');
            $table->text('tags')->nullable();
            $table->softDeletes();
            $table->timestamps();
        
          
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
