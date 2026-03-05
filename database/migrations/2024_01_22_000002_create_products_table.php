<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description');
            $table->decimal('price', 10, 2);
            $table->decimal('compare_price', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->string('sku')->unique();
            $table->string('image_url')->nullable();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(true);
            $table->integer('sales_count')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};