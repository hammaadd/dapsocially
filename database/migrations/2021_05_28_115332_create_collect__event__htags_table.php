<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectEventHtagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collect__event__htags', function (Blueprint $table) {
            $table->id();

            $table->string('account_name');
            $table->unsignedBigInteger('event_id')->nullable();
             $table->foreign('event_id')->references('id')->on('events')->onDelete('set null');
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
        Schema::dropIfExists('collect__event__htags');
    }
}
