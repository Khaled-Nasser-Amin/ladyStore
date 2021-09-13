<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateColorsTable extends Migration
{

    public function up()
    {
        Schema::create('colors', function (Blueprint $table) {
            $table->id();
            $table->float('price',11,2);
            $table->string('color');
            $table->float('sale',11,2)->default(0);
            $table->unsignedBigInteger('product_id')->nullable();
            $table->foreign('product_id')->references('id')->on('products')->onDelete('cascade')->onUpdate('cascade');
            $table->softDeletes();

        });
    }


    public function down()
    {
        Schema::dropIfExists('colors');
    }
}
