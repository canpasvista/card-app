<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
use App\Http\Requests\CardRequest;
use App\Models\gameModel;
use App\Services\gameService;
use App\States\gameState;
use Session;
use Validator;

use Illuminate\Support\Facades\Auth;

class playController extends Controller
{
    private $gameService;
    private $gameState;

    public function __construct(
        gameService $gameService,
        gameState $gameState
    ) {
        $this->gameService = $gameService;
        $this->gameState   = $gameState;
    }

    /**
     * ボードの表示
     *
     * @param  Request $request
     *
     * @return Illuminate\View\View
     */
    public function index(
        Request $request
    ) {
        return view('play');
    }
    /**
     * POST 勝負
     *
     * @param  Request $request
     *
     * @return Illuminate\View\View
     */
    public function store(
        Request $request
    ) {
        //入力値のvalidation
        $rule = [
            'card' => 'required|integer'
        ];
        $this->validate($request, $rule);

        //ゲームが開始状態でなければトップに戻る
        if ($this->gameService->checkOpenGame() == false) {
            return redirect('/');
        }


        $game_id = $this->gameService->getGameId();
        $game_model = gameModel::find($game_id);

        //カードがなければスコアに移動
        if ($this->gameState->countCardRemain() == 0) {
            return redirect('/api/score');
        }

        // プレイヤーカードの選択
        $card_index = $request->input('card');
        $history = $this->gameService->Play($card_index);

        //結果
        $this->gameState->setScore($history);

        //カードが残っているか？残ってなければステータスを終了に変更
        if ($this->gameState->countCardRemain() == 0) {
            //ステートを終了状態にする
            $this->gameService->endGame();
        }
        return json_encode($history);
    }

    /**
     * 勝負
     *
     * @param  Request $request
     *
     * @return Illuminate\View\View
     */
    public function playCard(
        gameService $gameService,
        GameRequest $request
    ) {

        //CPUのカードを取得
        $card_index = $request->input('card');
        $card = $gameService->gameState->getCardFromIndex($card_index, 1);
        if ($card == null) {
            return ([]);
        }
        //カードを比較して勝負
        $history = $gameService->Play($card_index);

        return ($history->toArray());
    }

    public function getCard(
        gameModel $gameModel,
        GameRequest $request
    ) {
        $gm = $request->makeGame();

        //未使用カードの取得
        return($gm->cards->toArray());
    }

    public function getGameState(
        gameModel $gameModel,
        GameRequest $request
    ) {

        //ゲームステータスの取得
        $gm = $request->makeGame();

        if (count($gm->cards) == 0) {
            $this->gameService->endGame();
        }
        return $this->gameService->gameState->getState();
    }
}
