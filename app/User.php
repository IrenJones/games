<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * Constants for game status
     *
     * @var const int
     */
    const NO_GAME = 0;
    const SEARCH_GAME = 1;
    const LIVE_GAME = 2;
    
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'registration_date',
        'last_visit',
        'default_game_type_id',
        'default_game_private',
        'is_admin',
    ];
    
    /**
     * Attributes to be casted.
     *
     * @var array
     */
    protected $casts = [
        'is_admin' => 'boolean'
    ];

    /**
     * The attributes excluded from the model's JSON form.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];
    
    /**
     * Show if user $id has an active game:
     * 0 - no game; 1 - searching for opponent; 2 - playing match
     *
     * @return int
     */
    public function getCurrentGameStatus()
    {
        $lastUserGame = $this->usergames->sortBy('id')->last();
        if (is_null($lastUserGame)) {
                return User::NO_GAME;
        }
        $game = $lastUserGame->game;
        if (is_null($game->time_finished)) {
            if (is_null($game->time_started)) {
                return User::SEARCH_GAME;
            } else {
                return User::LIVE_GAME;
            }
        } else {
            return User::NO_GAME;
        }
    }

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
     * @return UserGame[]
     */
    public function userGames()
    {
        return $this->hasMany('App\UserGame');
    }
    
    /**
     *
     * @return GameType
     */
    public function gameType()
    {
        return $this->belongsTo('App\GameType', 'default_game_type_id');
    }
    
    /**
     *
     * @return User[]
     */
    public function friends()
    {
        return $this->belongsToMany('App\User', 'friends_users', 'friend_id', 'user_id');
    }
    
    /**
     *
     * @return Token[]
     */
    public function tokens()
    {
        return $this->hasMany("App\Token");
    }
}
