<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
use App\Services\gameService;
use App\States\gameState;
use App\Models\gameModel;
use Session;

class scoreController extends Controller
{

    /**
     * 現在のスコアを表示
     *
     * @param  Request $request
     *
     * @return Array historyModel
     */
    public function score(
        GameRequest $request
    ) {
        $gm = $request->makeGame();

        return [$gm->histories->toArray()];
    }
}
