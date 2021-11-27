<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostingPlanPricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hosting_plan_prices', function (Blueprint $table) {
            $table->unSignedBigInteger('hosting_plans_id')->nullable();
            $table->foreign('hosting_plans_id')->references('id')->on('hosting_plans');
            $table->integer('price');
            $table->string('validity')->default('month');
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
        Schema::dropIfExists('hosting_plan_prices');
    }
}
