<?php
/**
 *
 * @Ananaskelly
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBoardsInfoTable extends Migration
{
    public function up()
    {
        Schema::create(
            'boardsInfo',
            function (Blueprint $table) {
                $table->integer('game_id')->unsigned();
                $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
                $table->tinyInteger('figure');
                $table->smallInteger('position');
                $table->boolean('color');
                $table->boolean('special');
                $table->smallInteger('turn_number');
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
        Schema::drop('boardsInfo');
    }
}
