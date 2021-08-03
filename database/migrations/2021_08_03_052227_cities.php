<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Cities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
         //
         Schema::create('cities', function (Blueprint $table) {
            $table->id();
            $table->integer('region_id');
            $table->integer('country_id');
            $table->string('name',255);
            $table->float('latitude');
            $table->float('longitude');
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
        //
        Schema::dropIfExists('cities');

    }
}
