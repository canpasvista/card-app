<?php

namespace App\States;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;

use App\Models\cardModel;
use App\Models\historyModel;
use App\Models\configModel;
use Illuminate\Support\Facades\DB;

class gameState
{
    /**
     * game_idをセッションに追加する
     */
    public function setGameId($id)
    {
        session(["game_id"=>$id]);
    }
    /**
     * セッションからgame_idを取得する
     * @return int game_id
     */
    public function getGameId()
    {
        $game_id = session('game_id');
        if (empty($game_id)) {
            return null;
        }
        return $game_id;
    }
    /**
     * game_no をセッションに追加する
     */
    public function setGameNo($no)
    {
        session(["game_no"=>$no]);
    }
    /**
     * セッションからgame_noを追加する
     * @return int game_no
     */
    public function getGameNo()
    {
        $game_no = session('game_no');
        if (empty($game_no)) {
            return 0;
        }
        return $game_no;
    }
    /**
     * game_state をセッションに追加する
     */
    public function setState($state)
    {
        session(["game_state"=>$state]);
    }
    /**
     * セッションからgame_state を取得する
     * @return int game_no
     */
    public function getState()
    {
        return session("game_state");
    }
    public function setMessage(string $message){
        session(['message'=> $message]);
    }
    public function clearMessage(){
        session(['message'=> '']);
    }
    public function setScore($score){
        session(['score_obj'=> $score]);
    }
    public function setScores(string $score){
        session(['scores'=> $score]);
    }

    /**
     * 使ったカードを使用済みにする
     */
    public function removeCardByIndex($index, $user_or_cpu)
    {
        DB::beginTransaction();
        try {
            $card = cardModel::lockForUpdate()->where(
                [
                    ["game_state_id" ,"=", $this->getGameId()],
                    ["user_or_cpu" ,"=", $user_or_cpu],
                    ["sort" ,"=", $index],
                    ["use" ,"=", 0],
                ]
            )->first();
            if (empty($card)) {
                $card = null;
            } else {
                $card->use = 1;
                $card->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return $card;
    }
    /**
     * ユーザーの使っていないカードの枚数を取得する
     * @return int count
     */
    public function countCardRemain()
    {
        return cardModel::where(
            [
                ["use" ,"=", 0],
                ["user_or_cpu" ,"=", 1],
                ["game_state_id" ,"=", $this->getGameId()],
            ]
        )->get()
         ->count();
    }
    /**
     * 使っていないカードを取得する
     * @return int count
     */
    public function getCardRemain($user_or_cpu=1, $use=0)
    {
        $remain = cardModel::where(
            [
                ["use" ,"=", $use],
                ["user_or_cpu" ,"=", $user_or_cpu],
                ["game_state_id" ,"=", $this->getGameId()],
            ]
        )->get();
        return ($remain);
    }
    /**
     * indexからcardModelを取得する
     * @return cardModel
     */
    public function getCardFromIndex($index, $user_or_cpu)
    {
        $cards = $this->getCardRemain($user_or_cpu);

        foreach ($cards as $card) {
            if ($card->sort == $index) {
                return $card;
            }
        }
        return null;
    }
    /**
     * 未使用カードの最初のcardModelを取得する
     * @return cardModel
     */
    public function getCardFromFirst($user_or_cpu)
    {
        $cards = $this->getCardRemain($user_or_cpu);

        foreach ($cards as $card) {
            return $card;
        }
        return null;
    }

    /**
     * カードデータを初期化する
     */
    public function initCard($game_id, $user_or_cpu, $cards)
    {
        foreach ($cards as $key => $card) {
            cardModel::create(
                [
                    "game_state_id" => $game_id,
                    "no" => $card['no'],
                    "color" => $card['color'],
                    "sort" => $key,
                    "use"  => 0,
                    "user_or_cpu" => $user_or_cpu
                ]
            );
        }
    }
}
