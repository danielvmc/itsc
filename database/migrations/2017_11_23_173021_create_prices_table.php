<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePricesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prices', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('coin_id')->unsigned();
            $table->decimal('price_btc', 30, 20)->nullable();
            $table->decimal('price_usd', 30, 20)->nullable();
            $table->bigInteger('volume')->nullable();
            $table->bigInteger('supply')->nullable();
            $table->decimal('percent_change_btc', 30, 20)->nullable();
            $table->decimal('percent_change_usd', 30, 20)->nullable();
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
        Schema::dropIfExists('prices');
    }
}
