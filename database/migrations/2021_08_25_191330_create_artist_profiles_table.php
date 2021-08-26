<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artistprofiles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('moniker')->nullable();
            $table->string('artform');
            $table->string('genre')->nullable();
            $table->string('profile_pic')->nullable();
            $table->string('short_bio')->nullable();
            $table->string('Interests')->nullable();
            $table->string('fbhandle')->nullable();
            $table->string('instahandle')->nullable();
            $table->string('twitterhandle')->nullable();
            $table->string('linkedinhandle')->nullable();
            $table->string('pinhandle')->nullable();
            $table->string('tthandle')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
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
        Schema::dropIfExists('artistprofiles');
    }
}
