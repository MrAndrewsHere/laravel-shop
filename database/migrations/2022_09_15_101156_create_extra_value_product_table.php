<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductFiltersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_value_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('extra_value_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('extra_value_id')->references('id')->on('extra_values')->onDelete('cascade');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade');
            $table->index('extra_value_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
//        Schema::table('product_filters',function (Blueprint $table){
//            $table->dropForeign(['product_id']);
//            $table->dropForeign(['filter_value_id']);
//            $table->dropIndex(['filter_value_id']);
//        });
        Schema::dropIfExists('extra_value_product');
    }
}
