<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAddsDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adds_details', function (Blueprint $table) {
            $table->id();
            $table->string('category',191);
            $table->string('account_type',191);
            $table->string('add_type');
            $table->unsignedBigInteger('add_id')->nullable();
            $table->foreign('add_id')->references('id')->on('adds')->onDelete('set null');
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
        Schema::dropIfExists('adds_details');
    }
}
