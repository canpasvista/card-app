<?php

namespace App\Http\Controllers\Front;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
use App\Services\gameService;
use App\Models\gameModel;
use App\States\userState;
use App\States\gameState;
use Validator;
use Session;

class boardController extends Controller
{
    /*
     *  メインページの表示
     *
     *  @return Illuminate\View\View
     */
    public function top()
    {
        return view('top');
    }

    /*
     *  ボードを表示
     *
     *  @return Illuminate\View\View
     */
    public function index(
        GameRequest $request
    ) {
        $gm = $request->makeGame();
        $history = $gm->lastHistory;
        $cards   = $gm->cards;

        //カードが０ならステータスを終了にする
        if (count($gm->cards) == 0) {
            $gs = new gameService();
            $gs->endGame();
        }


        return view(
            'board',
            ['cards'    =>  $cards,
            'history'   =>  $history]
        );
    }

    /*
     *  スコアの表示
     *
     * @param  Request $request
     *
     * @return Illuminate\View\View
     */
    public function score(
        GameRequest $request
    ) {

        //履歴の取得
        $gm = $request->makeGame();
        if (empty($gm->histories)) {
            $historys = [];
        } else {
            $historys = $gm->histories;
        }

        //スコア表示
        return view("score", [
                    'game_id'  => $gm->game_id,
                    'historys' => $historys]);
    }

    /*
     *  ログアウト
     *
     *  @return Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        session::put('jwt', '');
        session::put('game_id', '');
        session::put('game_no', '');
        session::put('game_state', '');

        return redirect('/');
    }
}
