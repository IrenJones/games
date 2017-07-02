<?php
/**
 *
 * @Ananaskelly
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class GameType extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'game_types';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'id',
        'type_name',
        'time_on_turn',
        'is_rating'
    );
    
    /**
     * Disable Timestamps fields
     *
     * @var boolean
     */
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
     * @return User[]
     */
    public function users()
    {
        return $this->hasMany('App\User', 'default_game_type_id');
    }
}
