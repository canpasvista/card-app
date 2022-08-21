<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->id();
            $table->integer("game_id");
            $table->integer("game_no");
            $table->string("result");
            $table->string("score");
            $table->string("status");
            $table->dateTime("start_time");
            $table->dateTime("end_time");
            $table->integer("play_time");
            $table->timestamps();
            $table->index(['game_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('results');
    }
};
