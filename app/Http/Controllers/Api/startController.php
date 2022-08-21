<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\gameService;

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
    ){

        $game_id = $gameService->newGame();
        session(['game_id',$game_id]);

        return ['game_id'=>$game_id];
    }
}
