<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilterValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extra_values', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('extra_id');
            $table->foreign('extra_id')->references('id')->on('extras')->onDelete('cascade');
            $table->string('value');
            $table->index(['extra_id','value']);
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
//        Schema::table('filter_values',function (Blueprint $table){
//            $table->dropForeign(['filter_id']);
//            $table->dropIndex(['filter_id','value']);
//        });
        Schema::dropIfExists('extra_values');
    }
}
