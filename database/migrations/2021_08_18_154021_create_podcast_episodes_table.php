<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodcastEpisodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcast_episodes', function (Blueprint $table) {
            $table->id();
            $table->integer('podcast_serie_id')->unsigned()->nullable();
            $table->foreign('podcast_serie_id')->references('id')->on('postcast_series');
            $table->string('title');
            $table->integer('season');
            $table->integer('episode_number');
            $table->string('audio_file');
            $table->string('clip_art');
            $table->string('description');
            $table->string('privacy')->default('Privacy');
            $table->datetime('uploaded_at');
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
        Schema::dropIfExists('podcast_episodes');
    }
}
