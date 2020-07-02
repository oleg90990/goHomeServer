<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ads', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->integer('animal_id')->references('id')->on('animals')->index();
            $table->text('content')->nullable();
            $table->integer('breed_id')->references('id')->on('breeds')->nullable()->index();
            $table->integer('age');
            $table->boolean('active');
            $table->integer('user_id')->references('id')->on('users');
            $table->string('gender')->index();
            $table->string('sterilization')->index();
            $table->integer('city_id')->references('id')->on('cities')->index();
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
        Schema::dropIfExists('ads');
    }
}
