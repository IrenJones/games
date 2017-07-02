<?php

namespace App\Http\Controllers\Ajax;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Game;
use App\Http\Controllers\BaseController;
use Auth;

class TurnController extends BaseController
{
    /**
     * Make turn or not
     *
     * @return json
     */
    public function turn(Request $msg)
    {
        $data = json_decode($msg->getContent(), true);
        $user=  Auth::user();
        
        $game = Game::find($data['game']);
        
        $turnValidatedSuccessfully = $game->turn(
            $user,
            $data['figure'],
            $data['x'],
            $data['y'],
            $data['typeId']
        );

        if ($turnValidatedSuccessfully === true) {
            $answer = [
                'name' => 'turn',
                'data' =>
                [
                    'state' => 'success'
                ]
            ];
        } else {
            $answer = [
                'name' => 'turn',
                'data' =>
                [
                    'state' => 'failed'
                ]
            ];
        }
        return response()->json($answer);
    }
}
