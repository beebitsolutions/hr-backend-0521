<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDogParkTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dog_park', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->unsignedBigInteger('dog_id');
            $table->unsignedBigInteger('park_id');

            $table->foreign('dog_id')->references('id')->on('dogs');
            $table->foreign('park_id')->references('id')->on('parks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dog_park');
    }
}
