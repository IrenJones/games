<?php
/**
 *
 * @IrenJones
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTurnInfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create(
            'turnInfo',
            function (Blueprint $table) {
                $table->integer('game_id')->unsigned();
                $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
                $table->smallInteger('turn_number');
                $table->smallInteger('move');
                $table->tinyInteger('options');
                $table->datetime('turn_start_time');
                $table->boolean('user_turn');
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
        Schema::drop('turnInfo');
    }
}
