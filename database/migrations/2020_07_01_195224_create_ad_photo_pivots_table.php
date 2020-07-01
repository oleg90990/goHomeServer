<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdPhotoPivotsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ad_photos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('ad_id')->index();
            $table->string('patch');
            $table->json('vk')->nullable();
            // foreign keys
            $table->foreign('ad_id')->references('id')->on('ads');
        });

        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn('images');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ad_photos');
    }
}
