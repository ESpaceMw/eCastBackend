<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodcastEpisodeSubscriptionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcast_episode_subscriptions', function (Blueprint $table) {
            $table->id();
            $table->unSignedBigInteger('podcast_episodes_id')->nullable();
            $table->foreign('podcast_episodes_id')->references('id')->on('podcast_episodes');
            $table->string('type');
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
        Schema::dropIfExists('podcast_episode_subscriptions');
    }
}
