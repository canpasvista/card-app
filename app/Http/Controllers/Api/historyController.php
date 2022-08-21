<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\historyModel;
use App\Services\gameService;
use App\Models\gameModel;
use App\Http\Requests\GameRequest;

class historyController extends Controller
{
    /**
     * 履歴の削除
     *
     * @param  Request $request
     *
     * @return Illuminate\View\View
     */
    public function index(
        GameRequest $request
    ) {
        //ページネーション付きで履歴の取得
        $games = gameModel::orderBy('id', 'desc')->paginate(12);

        $page = \Request::input('page');
        if (empty($page)) {
            $page = 1;
        }

        return view('history', compact('games', 'page'));
    }
}
