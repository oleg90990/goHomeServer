<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdVkpostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_vkposts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_id')->index();
            $table->string('post_id');
            $table->string('owner_id');
            // foreign keys
            $table->foreign('ad_id')->references('id')->on('ads');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_vkposts');
    }
}
