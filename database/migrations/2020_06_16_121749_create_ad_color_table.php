<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdColorTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_color', function (Blueprint $table) {
            $table->unsignedBigInteger('ad_id');
            $table->unsignedBigInteger('color_id');
            // foreign keys
            $table->foreign('ad_id')->references('id')->on('ads');
            $table->foreign('color_id')->references('id')->on('colors');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ad_color', function (Blueprint $table) {
            //
        });
    }
}
