<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBasicInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('basic_infos', function (Blueprint $table) {
            $table->id();
            $table->unSignedBigInteger('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('clip_art');
            $table->string('podcast_url');
            $table->string('title');
            $table->string('tagline');
            $table->string('description');
            $table->string('category');
            $table->string('language')->default('english');
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
        Schema::dropIfExists('basic_infos');
    }
}
