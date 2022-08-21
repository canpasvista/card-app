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
        Schema::create('historys', function (Blueprint $table) {
            $table->id();
            $table->integer("game_state_id");
            $table->integer("no");
            $table->integer("user_card");
            $table->integer("user_card_color");
            $table->integer("cpu_card");
            $table->integer("cpu_card_color");
            $table->integer("point");
            $table->timestamps();
            $table->index(['game_state_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('historys');
    }
};
