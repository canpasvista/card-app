<?php

namespace App\States;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Session;

use App\Models\cardModel;
use App\Models\historyModel;
use App\Models\configModel;
use Illuminate\Support\Facades\DB;

class gameState extends Model
{
    use HasFactory;
    protected $table = "games";
    protected $fillable = ["game_id","play_no","card_1","card_2","point","result"];

    public function cards(){
        return $this->hasMany(cardModel::class)->orderBy('sort', 'asc');
    }
    public function histories(){
        return $this->hasMany(historyModel::class);
    }

    public function getHistory($game_id){
        return gameState::where('game_id',$game_id)->get();
    }
    public function addHistory($game_id,$game_no,$card1,$card2,$point,$result){
        gameState::create(
            [
                "game_id" => $game_id,
                "play_no" => $game_no,
                "card_1"  => $card1,
                "card_2"  => $card2,
                "point"   => $point,
                "result"  => json_encode($result)
            ]
        );
    }
    public function removeCardByIndex($index,$user_or_cpu){
        DB::beginTransaction();
        try {
            $card = cardModel::lockForUpdate()->where(
                [
                    ["game_state_id" ,"=", $this->getGameId()],
                    ["user_or_cpu" ,"=", $user_or_cpu],
                    ["sort" ,"=", $index],
                    ["use" ,"=", 0],
                ])->first();
            if (empty($card)) {
                $card = null;
            }else{
                $card->use = 1;
                $card->save();
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
        return $card;

    }
    public function countCardRemain(){
        $remain = cardModel::where(
            [
                ["use" ,"=", 0],
                ["user_or_cpu" ,"=", 1],
                ["game_state_id" ,"=", $this->getGameId()],
            ])->get();
        return count($remain);
    }
    public function getCardRemain($user_or_cpu=1,$use=0){
        $remain = cardModel::where(
            [
                ["use" ,"=", $use],
                ["user_or_cpu" ,"=", $user_or_cpu],
                ["game_state_id" ,"=", $this->getGameId()],
            ])->get();
        return ($remain);
    }
    public function getCardFromIndex($index,$user_or_cpu){
        $cards = $this->getCardRemain($user_or_cpu);

        foreach($cards as $card){
            if( $card->sort == $index)
                return $card;
        }
            return null;
    }
    public function getCardFromFirst($user_or_cpu){
        $cards = $this->getCardRemain($user_or_cpu);

        foreach($cards as $card){
            return $card;
        }
        return null;
    }
    public function updateCard($game_id,$user_or_cpu,$cards_index){
        DB::beginTransaction();
        try {
            $model = cardModel::lockForUpdate()->where([
                "game_id" => $game_id,
                "user_or_cpu" => $user_or_cpu,
                "sort" => $card_index
            ])->first();
            $model->use= 1;
            $model->save();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
    public function initCard($game_id,$user_or_cpu,$cards){
        if( $user_or_cpu == 1){
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
        if( $user_or_cpu == 0){
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
    public function setGameId($id){
        session(["game_id"=>$id]);
    }
    public function getGameId(){
        $game_id = session('game_id');
        if (empty($game_id)) {
            return null;
        }
        return $game_id;
    }
    public function setState($state){
        session(["game_state"=>$state]);
    }
    public function getState(){
        return session("game_state");
    }
    public function setCardState($cards){
        session(["cards"=>json_encode($cards)]);
    }

}
