<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWantedPhotosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wanted_photos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('photo_priority_one')->nullable();
            $table->string('photo_priority_two')->nullable();
            $table->string('photo_priority_three')->nullable();
            $table->string('photo_priority_four')->nullable();
            $table->string('photo_priority_five')->nullable();
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
        Schema::dropIfExists('wanted_photos');
    }
}
