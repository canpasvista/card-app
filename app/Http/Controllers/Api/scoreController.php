<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Session;
use Illuminate\Http\Request;
use App\Services\gameService;
use App\States\gameState;
use App\States\userState;
use App\Models\gameModel;
use App\Http\Requests\GameRequest;

class scoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(
        gameService $gameService,
        gameState $gameState,
        userState   $userState
    ) {
        //game id がセットされてなければトップに戻る
        $game_id = $gameService->getGameId();
        if( empty($game_id))
            throw new \Exception("no game_id");

        $gs      = gameState::find($game_id);
        $userState->setScore(json_encode($gs->histories));

        return $gs->histories;
    }

    public function index(
        gameService $gameService,
        gameState   $gameState,
        userState   $userState
    ) {
        //game id がセットされてなければトップに戻る
        $game_id = $gameService->getGameId();
        if( empty($game_id))
            throw new \Exception("no game_id");

        $gm      = gameModel::find($game_id);
        $userState->setScores(json_encode($gm->histories));

        //スコアの表示
        return view("score",['results'=>$gm->histories]);
    }

    public function score(
        GameRequest $request
    ){

        $gm = $request->makeGame();
        //gameModel::find($game_id);

        return [$gm->histories->toArray()];
    }
}
