<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GameRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\historyModel;
use App\Models\gameModel;

class deleteHistoryController extends Controller
{
    /**
     * 履歴の削除
     *
     * @param  Request $request
     * @param  historyModel $history
     *
     * @return Illuminate\Http\RedirectResponse
     */
    public function delete(
        GameRequest $request,
        historyModel $history
    )
    {
        $game_id = $request->input('game_id');

        DB::beginTransaction();
        try {
            historyModel::where('game_state_id', $game_id)->delete();
            gameModel::where("game_id", $game_id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return redirect('/history');
    }
}
