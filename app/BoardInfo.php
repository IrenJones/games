<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BoardInfo extends Model
{
    /**
     * Table name
     *
     * @var string
     */
    protected $table = 'board_infos';
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = array(
        'game_id',
        'figure',
        'position',
        'color',
        'special',
        'turn_number'
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
