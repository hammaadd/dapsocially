<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventSocialPostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event__social__posts', function (Blueprint $table) {
            $table->id();
            $table->string('fb_page_name',191)->nullable();
            $table->string('tw_page_name',191)->nullable();
            $table->string('insta_page_name',191)->nullable();
            $table->string('tiktok_page_name',191)->nullable();
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
        Schema::dropIfExists('event__social__posts');
    }
}
