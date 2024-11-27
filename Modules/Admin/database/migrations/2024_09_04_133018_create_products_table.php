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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->nullable();
            $table->tinyInteger('hasVariation')->default(0);
            $table->text('description')->nullable();
            $table->text('options')->nullable();
            $table->decimal('price', 10, 2)->nullable();
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->decimal('cost', 10, 2)->nullable();
            $table->string('status')->default('archived');

            $table->tinyInteger('new')->default(0);
            $table->tinyInteger('featured')->default(0);
            $table->tinyInteger('sale')->default(0);
            $table->tinyInteger('offered')->default(0);

            $table->tinyInteger('display')->default(0);
            $table->string('vendor')->nullable();
            $table->string('product_type')->nullable();
            $table->string('collections')->nullable();
            $table->unsignedBigInteger('collection_id')->default(0);
            $table->text('tags')->nullable();

            $table->string('meta_title')->nullable();
            $table->string('meta_keywords')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('video_url')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
