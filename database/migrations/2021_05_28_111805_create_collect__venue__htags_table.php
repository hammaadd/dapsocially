<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectVenueHtagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collect__venue__htags', function (Blueprint $table) {
            $table->id();
            $table->string('account_name');
            $table->unsignedBigInteger('venue_id')->nullable();
            $table->foreign('venue_id')->references('id')->on('venues')->onDelete('set null');
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
        Schema::dropIfExists('collect__venue__htags');
    }
}
