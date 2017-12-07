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
            $table->decimal('price_btc', 60, 20)->nullable();
            $table->decimal('price_usd', 60, 20)->nullable();
            $table->decimal('volume', 60, 20)->nullable();
            $table->bigInteger('supply')->nullable();
            $table->bigInteger('market_cap')->nullable();
            $table->decimal('percent_market', 60, 20);
            $table->decimal('percent_volume', 60, 20);
            $table->decimal('percent_btc', 60, 20);
            $table->decimal('percent_usd', 60, 20);
            $table->decimal('btc_s', 60, 20);
            $table->decimal('usd_s', 60, 20);
            $table->decimal('speed', 60, 20);
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
