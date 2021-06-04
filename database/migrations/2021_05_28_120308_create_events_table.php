<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->string('event_name',191);
            $table->string('c_image',191)->nullable();
            $table->text('e_description');
            $table->string('hashtag',191);
            $table->unsignedBigInteger('approve_htag');
            $table->string('wall_bg_image',191)->nullable();
            $table->string('start_time',191);
            $table->string('end_time',191);
            $table->string('wall_location_msg')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users')->onDelete('set null');
            $table->unsignedBigInteger('social_posts')->nullable();
            $table->foreign('social_posts')->references('id')->on('event__social__posts')->onDelete('set null');
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
        Schema::dropIfExists('events');
    }
}
