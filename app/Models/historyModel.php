<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class historyModel extends Model
{
    use HasFactory;
    protected $table = "historys";
    protected $fillable = ["game_state_id","no","user_card","user_card_color","cpu_card","cpu_card_color","point"];

    /**
     *
     * 履歴の追加
     *
     * @param int game_state_id
     * @param int user_card
     * @param int user_card_color
     * @param int cpu_card
     * @param int cpu_card_color
     * @param int point
     *
     */
    public function add($game_state_id, $no, $user_card, $user_card_color, $cpu_card, $cpu_card_color, $point)
    {
        historyModel::create(
            [
                "game_state_id" => $game_state_id,
                "no"            => $no,
                "user_card"     => $user_card,
                "user_card_color"=>$user_card_color,
                "cpu_card"      => $cpu_card,
                "cpu_card_color"=> $cpu_card_color,
                "point"         => $point
            ]
        );
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
    public function getOne($game_state_id, $no)
    {
        return historyModel::where(
            [
            ["game_state_id","=",$game_state_id],
            ["no","=",$no]
            ]
        )->first();
    }
    /**
     *
     * 結果メッセージを取得
     *
     * @return string
     */
    public function getMessage()
    {
        if ($this->user_card > $this->cpu_card) {
            return "{$this->user_card}:{$this->cpu_card} プレイヤーの勝ち";
        }
        if ($this->user_card < $this->cpu_card) {
            return "{$this->user_card}:{$this->cpu_card} CPUの勝ち";
        }
        if ($this->user_card == $this->cpu_card) {
            return "{$this->user_card}:{$this->cpu_card} 引き分け";
        }
        return '';
    }
}
