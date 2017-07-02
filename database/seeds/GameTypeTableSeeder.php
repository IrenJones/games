<?php
/**
 *
 * @Ananaskelly
 */
use Illuminate\Database\Seeder;
use App\GameType;

class GameTypeTableSeeder extends Seeder
{
    /**
     *
     * @return void
     */
    public function run()
    {
        GameType::create(['type_name' => 'rapid', 'time_on_turn' => '1', 'is_rating' => '0']);
        GameType::create(['type_name' => 'normal', 'time_on_turn' => '5', 'is_rating' => '1']);
        GameType::create(['type_name' => 'long', 'is_rating' => '0']);
    }
}
