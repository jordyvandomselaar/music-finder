<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSpotifyUserTrackTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('spotify_user_track', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('spotify_user_id');
            $table->unsignedBigInteger('track_id');
            $table->foreign('spotify_user_id')->references('id')->on('spotify_users');
            $table->foreign('track_id')->references('id')->on('tracks');
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
        Schema::dropIfExists('spotify_user_track');
    }
}
