<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNProductCategoryAndNProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('n_product_category', function (Blueprint $table) {
            $table->id(); 
            $table->string('category_name', 255);
            $table->integer('parent_id');
            $table->string('status', 10);
            $table->timestamps(0); 
            $table->primary('id'); 
        });

        
        Schema::create('n_products', function (Blueprint $table) {
            $table->id(); 
            $table->string('product_id', 255); 
            $table->string('product_title', 500); 
            $table->unsignedBigInteger('product_category'); 
            $table->string('product_price', 100); 
            $table->string('product_sale_price', 100);
            $table->text('product_short_description'); 
            $table->text('product_description'); 
            $table->string('product_image', 255);
            $table->string('status', 10); 
            $table->string('created_by', 255);
            $table->timestamps(0); 
            $table->primary(['id', 'product_id']); 
        });

        Schema::table('n_products', function (Blueprint $table) {
            $table->foreign('product_category')
                  ->references('id')
                  ->on('n_product_category')
                  ->onDelete('restrict')
                  ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        
        Schema::table('n_products', function (Blueprint $table) {
            $table->dropForeign(['product_category']);
        });

        
        Schema::dropIfExists('n_products');

        Schema::dropIfExists('n_product_category');
    }
}
