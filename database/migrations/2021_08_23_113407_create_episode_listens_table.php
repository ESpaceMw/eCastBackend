<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEpisodeListensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('episode_listens', function (Blueprint $table) {
            $table->id();
            $table->unSignedBigInteger('podcast_serie_id')->nullable();
            $table->foreign('podcast_serie_id')->references('id')->on('podcast_series');
            $table->unSignedBigInteger('podcast_episode_id')->nullable();
            $table->foreign('podcast_episode_id')->references('id')->on('podcast_episodes');
            $table->integer('user_id');
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
        Schema::dropIfExists('episode_listens');
    }
}
