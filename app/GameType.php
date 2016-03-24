<?php
/**
 *
 * @Ananaskelly
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class GameType extends Model
{
    
    protected $table = 'game_types';
    
    protected $fillable = array(
        'id',
        'type_name',
        'time_on_turn',
        'is_rating'
    );
    
    public $timestamps = false;
    /**
     *
     * @return UserIngameInfo[]
     */
    public function userIngameInfos()
    {
        return $this->hasMany('App\UserIngameInfo');
    }
    
    /**
     *
     * @return Game[]
     */
    public function games()
    {
        return $this->hasMany('App\Game');
    }
    
    /**
     *
     * @return UserDefault[]
     */
    public function userDefaults()
    {
        return $this->hasMany('App\UserDefault');
    }
}