<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coins', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('coin_id')->unique();
            $table->integer('rank');
            $table->string('symbol')->unique();
            $table->string('name');

            $table->double('supply');
            $table->double('maxSupply')->nullable();
            $table->double('marketCapUsd');
            $table->double('volumeUsd24Hr');

            $table->double('priceUsd');
            $table->double('changePercent24Hr');
            $table->double('vwap24Hr');

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
        Schema::dropIfExists('coins');
    }
};
