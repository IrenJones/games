<?php
/**
 *
 * @Ananaskelly
 */
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddMoreFieldsToUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->tinyInteger('default_game_type_id')->unsigned()->nullable();
            $table->foreign('default_game_type_id')->references('id')->on('game_types')->onDelete('cascade');
            $table->boolean('default_game_private');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign('users_default_game_type_id_foreign');
            $table->dropColumn(['default_game_type_id', 'default_game_private']);
        });
    }
}
