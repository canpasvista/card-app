<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class gameModel extends Model
{
    use HasFactory;
    protected $table = "game";
    protected $fillable = ["game_id","no"];

    /**
     *
     * 新規gameModelをcreate
     *
     * @param int game_id
     *
     * @return void
     *
     */
    public function setNewGame($game_id)
    {
        gameModel::create(
            [
                'game_id' => $game_id,
                'no'      => 0
            ]
        );
    }

    /**
     *
     * game_idに一致するgameModelを返却
     *
     * @param int game_id
     *
     * @return void
     *
     */
    public static function find($game_id)
    {
        return gameModel::where(
            ['game_id' => $game_id]
        )->first();
    }

    /**
     *
     * game_noを加算して返却
     *
     * @param int game_id
     *
     * @return int game_no
     *
     */
    public function addGameNo($game_id)
    {
        DB::beginTransaction();
        try {
            $item = gameModel::lockForUpdate()->where(
                ['game_id' => $game_id]
            )->first();
            $item->no = $item->no+1;
            $item->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return $item->no;
    }

    /**
     * associate hasmany historyModel
     * 履歴一覧
     */
    public function histories()
    {
        return $this->hasMany(historyModel::class, "game_state_id", "game_id")
                    ->orderBy('id', 'asc');
    }
    /**
     * associate hasone historyModel
     * 最後に追加した履歴
     */
    public function lastHistory()
    {
        return $this->hasOne(historyModel::class, "game_state_id", "game_id")
                    ->orderBy('id', 'desc');
    }
    /**
     * associate hasmany cardModel
     * ユーザ所有で未使用のカード一覧
     */
    public function cards()
    {
        return $this->hasMany(cardModel::class, "game_state_id", "game_id")
                    ->where('user_or_cpu', 1)
                    ->where('use', 0)
                    ->orderBy('sort', 'asc');
    }

    public function drop($game_id)
    {
        DB::beginTransaction();
        try {
            historyModel::where('game_state_id', $game_id)->delete();
            gameModel::where("game_id", $game_id)->delete();

            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
}
