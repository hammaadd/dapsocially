<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->string('venue_name',191);
            $table->string('c_image',191)->nullable();
            $table->text('v_description');
            $table->string('hashtag',191);
            $table->string('approve_htag')->nullable();
            $table->string('wall_bg_image',191)->nullable();
            $table->string('start_time',191);
            $table->string('start_date',191);
            $table->string('end_time',191);
            $table->string('end_date',191);
            $table->string('wall_location_msg')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('location_id')->nullable();
            $table->foreign('location_id')->references('id')->on('locations')->onDelete('set null');
            $table->unsignedBigInteger('social_posts_id')->nullable();
            $table->foreign('social_posts_id')->references('id')->on('venue__social__posts')->onDelete('set null');
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
        Schema::dropIfExists('venues');
    }
}
