<?php
/*
 *
 * @artesby
 */
namespace App;

use Illuminate\Database\Eloquent\Model;

class UserGame extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table ='user_games';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'game_id',
        'color',
        'reserve_time',
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
     * @return Game
     */
    public function game()
    {
        return $this->belongsTo('App\Game');
    }
}
