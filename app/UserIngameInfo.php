<?php
/**
 *
 * @IrenJones
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserIngameInfo extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table ='user_ingame_infos';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'game_type_id',
        'user_id',
        'game_rating',
        'games',
        'wins'
    ];
    
    /**
     * Disable Timestamps fields
     *
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     *
     * @return User
     */
    public function user()
    {
        return $this->belongsTo('App\User');
    }
   
    /**
     *
     * @return GameType
     */
    public function gameType()
    {
        return $this->belongsTo('App\GameType');
    }
}
