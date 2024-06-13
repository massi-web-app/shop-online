<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('ename')->nullable();
            $table->string('product_url');
            $table->integer('price')->nullable();
            $table->string('discount_price');
            $table->boolean('show')->default(true);
            $table->integer('view');
            $table->text('keywords')->nullable();
            $table->text('summery');
            $table->boolean('special')->default(false);
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('brand_id');
            $table->string('image_url')->nullable();
            $table->string('description')->nullable();
            $table->integer('order_number')->default(0);
            $table->softDeletes();
            $table->timestamps();



            $table->foreign('category_id')
                ->references('id')
                ->on('categories')
                ->onUpdate('cascade')
                ->onDelete('cascade');


            $table->foreign('brand_id')
                ->references('id')
                ->on('brands')
                ->onUpdate('cascade')
                ->onDelete('cascade');

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
