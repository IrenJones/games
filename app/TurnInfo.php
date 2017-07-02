<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TurnInfo extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table= 'turn_infos';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
            'game_id',
            'turn_number',
            'move',
            'options',
            'turn_start_time',
            'user_turn'
    );

    /**
     * Disable Timestamps fields
     *
     * @var boolean
     */
    public $timestamps = false;
    
    /**
     *
     * @return Game
     */
    public function game()
    {
        return $this->belongsTo('App\Game');
    }
}
