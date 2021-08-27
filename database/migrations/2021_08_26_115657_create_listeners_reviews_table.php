<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListenersReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('listeners_reviews', function (Blueprint $table) {
            $table->id();
            $table->integer('channels_id')->unsigned()->nullable();
            $table->foreign('channels_id')->references('id')->on('channels');
            $table->string('reviewer_name');
            $table->string('reviewer_avatar');
            $table->string('review');
            $table->integer('stars')->default(0);
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
        Schema::dropIfExists('listeners_reviews');
    }
}
