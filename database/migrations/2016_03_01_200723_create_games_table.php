<?php
/**
 *
 * @Ananaskelly
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'games',
            function (Blueprint $table) {
                $table->increments('id');
                $table->tinyInteger('game_type_id')->unsigned();
                $table->foreign('game_type_id')->references('id')->on('game_types')->onDelete('cascade');
                $table->boolean('private');
                $table->dateTime('time_started');
                $table->dateTime('time_finished');
                $table->boolean('winner');
                $table->tinyInteger('bonus');
            }
        );
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('games');
    }
}
