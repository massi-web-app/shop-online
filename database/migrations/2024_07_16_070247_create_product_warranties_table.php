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
        Schema::create('product_warranties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('warranty_id');
            $table->unsignedBigInteger('color_id')->nullable();
            $table->integer('real_product_price');
            $table->integer('sale_product_price');
            $table->integer('send_time');
            $table->integer('seller_id')->nullable();
            $table->integer('product_number')->nullable();
            $table->integer('product_number_cart')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->foreign('warranty_id')
                ->references('id')
                ->on('warranties')
                ->onDelete('cascade')
                ->onUpdate('cascade');


            $table->foreign('color_id')
                ->references('id')
                ->on('colors')
                ->onDelete('cascade')
                ->onUpdate('cascade');




        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_warranties');
    }
};
