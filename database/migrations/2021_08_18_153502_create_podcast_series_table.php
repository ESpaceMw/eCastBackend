<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePodcastSeriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('podcast_series', function (Blueprint $table) {
            $table->id();
            $table->unSignedBigInteger('channels_id')->nullable();
            $table->foreign('channels_id')->references('id')->on('channels');
            $table->string('title');
            $table->string('cover_art');
            $table->integer('seasons');
            $table->string('subscription_type');
            $table->string('category');
            $table->text('description');
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
        Schema::dropIfExists('podcast_series');
    }
}
