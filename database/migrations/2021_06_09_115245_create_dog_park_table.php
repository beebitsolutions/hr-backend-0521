<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDogParkTable extends Migration
{
    private const TABLE = 'dog_park';

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create(self::TABLE, function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('dog_id');
            $table->unsignedBigInteger('park_id');
            $table->boolean('leave')
                ->default(0)
                ->comment('the dog leaves the park.');
            $table->timestamps();

            $table->foreign('dog_id')
                ->references('id')
                ->on('dogs');

            $table->foreign('park_id')
                ->references('id')
                ->on('parks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(self::TABLE);
    }
}
