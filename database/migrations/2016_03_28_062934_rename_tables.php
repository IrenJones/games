<?php
/**
 *
 * @author malinink
 */
use Illuminate\Database\Migrations\Migration;

class RenameTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('boardsInfo', 'board_infos');
        Schema::rename('turnInfo', 'turn_infos');
        Schema::rename('user_ingame_info', 'user_ingame_infos');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('user_ingame_infos', 'user_ingame_info');
        Schema::rename('turn_infos', 'turnInfo');
        Schema::rename('board_infos', 'boardsInfo');
    }
}
