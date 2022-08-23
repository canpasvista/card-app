<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Services\gameService;
use App\States\gameState;

class startController extends Controller
{
    /*
     *  ゲームの新規開始
     *
     * @param  gameService $gameService
     *
     * @return Illuminate\View\View
     */
    public function openboard(
        gameService $gameService,
        gameState $gameState
    ) {
        $game_id = $gameService->newGame();
        $gameState->setGameId($game_id);

        return ['game_id'=>$game_id];
    }
}
