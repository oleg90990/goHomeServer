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
            $table->integer('animal_id')->references('id')->on('animals');
            $table->text('content')->nullable();
            $table->integer('breed_id')->references('id')->on('breeds')->nullable();
            $table->string('phone');
            $table->integer('age');
            $table->boolean('active');
            $table->integer('user_id')->references('id')->on('users');
            $table->string('gender');
            $table->string('sterilization');
            $table->json('images')->nullable();
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
