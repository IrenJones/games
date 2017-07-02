<?php
/**
 *
 * @author Ananaskelly
 */
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Requests\SearchGameFormRequest;
use Carbon\Carbon;
use Auth;
use App\GameType;
use App\Game;
use App\UserGame;

class GameController extends BaseController
{
    /**
     * Show the form for games params.
     *
     * @return
     */
    public function search()
    {
        $gameTypesColumn = array_column(GameType::all('type_name')->toArray(), 'type_name');
        $gameTypes = array_combine($gameTypesColumn, $gameTypesColumn);
        return view('game.search', compact('gameTypes'));
    }
    /**
     * Find game with params or create new game
     *
     * @return void
     */
    public function create(SearchGameFormRequest $request)
    {
        $gameType = GameType::where('type_name', '=', $request->type)->first();
        $game = Game::createGame($gameType, $request->status, Auth::user());
        if ($game instanceof Game) {
            return redirect()->route('game', ['gameId' => $game->id]);
        }
        /*
         * throw error via flash
         */
        return redirect('/home');
    }
    
    public function game($gameId)
    {
        $user = Auth::user();
        $game = Game::find($gameId);
        $secondPlayerInGame = null;
        $colorOfGamer = Game::BLACK;
        $board=[];
        $newPos=[];
        $state=0;
        $turnNumber = 0;
        
        $turnInfo = $game->turnInfos->sortBy('id')->last();
        if (!is_null($turnInfo)) {
            $turnNumber = $turnInfo -> turn_number;
        }
        /*
         * check permissions
         */
        $players = [null, null];
        $usersNames = [null, null];
        /* @var $game Game */
        foreach ($game->userGames as $userGame) {
            /* @var $userGame UserGame */
            $players[(int) $userGame->color] = $userGame->user->id;
            if ($userGame->user->id === $user->id) {
                $colorOfGamer = (int) $userGame->color;
            }
        }
        

        if ($players[0] != null && $players[1] != null) {
            $secondPlayerInGame = 1;
            foreach ($game->userGames as $userGame) {
                $usersNames[(int) $userGame->color] = $userGame->user->name;
            }
            foreach ($game->boardInfos as $boardInfo) {
                $typeNumber = $boardInfo->figure;
                $diffTypes = ['pawn', 'rook', 'knight', 'bishop', 'king', 'queen'];
                $type = $diffTypes[$typeNumber];

                if ($boardInfo->color == (int)Game::BLACK) {
                    $colorFigure = 'black';
                } else {
                    $colorFigure = 'white';
                }

                $pos = $boardInfo->position;

                $boardInfoData = [
                    'type' => $type,
                    'position' => $pos,
                    'id' => $boardInfo->id,
                    'color' => $colorFigure,
                ];
                $board[] = $boardInfoData;
            }
        }

        if (!is_null($secondPlayerInGame) && $colorOfGamer === (int)Game::WHITE) {
            foreach ($board as $figureOne) {
                for ($i = 1; $i < 9; $i++) {
                    for ($j = 1; $j < 9; $j++) {
                        if ($i * 10 + $j === (int) $figureOne['position']) {
                            $state=1;
                            $info= [
                                'type' => $figureOne['type'],
                                'position' => (9 - $i) * 10 + (9-$j),
                                'id' => $figureOne['id'],
                                'color' => $figureOne['color'],
                            ];
                            $newPos[] = $info;
                        }
                    }
                }
            }
        }
        if ($state === 0) {
            return view('game.game', [
                'gameId' => $game->id,
                'userWhite' => $usersNames[0],
                'userBlack' => $usersNames[1],
                'userId' => $user->id,
                'playerWhiteId' => $players[0],
                'playerBlackId' => $players[1],
                'boards' => $board,
                'colorOfGamer' => $colorOfGamer,
                'secondPlayerInGame' => $secondPlayerInGame,
                'turnNumber' => $turnNumber
            ]);
        } else {
            return view('game.game', [
                'gameId' => $game->id,
                'userWhite' => $usersNames[0],
                'userBlack' => $usersNames[1],
                'userId' => $user->id,
                'playerWhiteId' => $players[0],
                'playerBlackId' => $players[1],
                'boards' => $newPos,
                'colorOfGamer' => $colorOfGamer,
                'secondPlayerInGame' => $secondPlayerInGame,
                'turnNumber' => $turnNumber
            ]);
        }
    }
}
