<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVSocialWallsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('v_social_walls', function (Blueprint $table) {
            $table->id();
            $table->longText('text')->nullable();
            $table->text('image')->nullable();
            $table->enum('platform',['facebook','twitter','instagram','tiktok']);
            $table->text('user_img')->nullable();
            $table->string('username',191)->nullable();
            $table->string('posted_at',191)->nullable();
            $table->unsignedBigInteger('venue_id')->nullable();
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('set null');
            $table->text('url')->nullable();
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
        Schema::dropIfExists('v_social_walls');
    }
}
