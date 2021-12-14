<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->unSignedBigInteger('channel_id')->nullable();
            $table->foreign('channel_id')->references('id')->on('channels');
            $table->string('title');
            $table->string('cover_art');
            $table->string('content');
            $table->boolean('is_promoted')->default(false);
            $table->date('event_due');
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
        Schema::dropIfExists('events');
    }
}
