<?php

namespace App\Services;

use App\States\gameState;
use App\Models\gameModel;
use App\States\userState;
use App\Models\configModel;
use App\Models\cardModel;
use App\Models\historyModel;
use App\Models\toukei\toukei1Model;
use App\Models\toukei\toukei2Model;


use Session;
use App\Services\cpuStorategeService;
use Illuminate\Support\Facades\DB;

class gameService
{
    public $gameState;
    public $game_id;
    private $gameModel;
    private $userState;
    private $historyModel;
    private $cpuStoratege;

    public function __construct(
    ) {
        $this->gameModel= new gameModel();
        $this->userState =new userState();
        $this->historyModel = new historyModel();
        $this->cpuStoratege = new cpuStorategeService();

        $this->gameState = new gameState();
    }

    /*
     *  新規ゲームを開始し、game id を返す
     * 
     *  return int game_id
     */
    public function newGame()
    {

        $this->userState->setScore('');
        $this->userState->clearMessage();

        $this->gameState->setState("open");

        $game_id = $this->setNewGameId();

        $this->initCard();

        return $game_id;

    }

    /*
     *  ゲームを終了状態にする
     * 
     *  return void
     */
    public function endGame()
    {
        if ($this->checkOpenGame()) {
            $game_id = $this->gameState->getGameId();
            $time0 = historyModel::where("game_state_id",$game_id)
                                 ->where("no",1)
                                 ->first();
            $time1 = historyModel::where("game_state_id",$game_id)
                                 ->where("no",13)
                                 ->first();
            toukei1Model::add($time0->created_at,$time1->created_at);
        }
            
        $this->gameState->setState("end");
    }

    /*
     *  ゲームが開始状態か確認する
     * 
     *  return bool $result
     */
    public function checkOpenGame(){
        $id = $this->gameState->getGameId();
        if(empty($id))return false;

        $state = $this->gameState->getState();

        if( $state != 'open')return false;

        return true;
    }

    /*
     *  userとCpuにカードを配る
     * 
     *  return void
     */
    public function initCard(){
        $this->gameState->initCard($this->game_id,1,$this->shuffle_card());
        $this->gameState->initCard($this->game_id,0,$this->shuffle_card());

        $cards = $this->gameState->getCardRemain();
        $this->gameState->setCardState($cards);
    }

    /*
     *  userの未使用カードを取得する
     * 
     *  return cardModel $cards
     */
    public function getRemainCards(){
        $cards = $this->gameState->getCardRemain();
        return $cards;
    }

    /*
     *  最後に行ったゲームの履歴を取得する
     * 
     *  return historyModel $history
     */
    public function getLastHistory(){
        $history  = new historyModel();
        $history = $history->where("game_state_id",$this->getGameId())
                ->first();
        return $history;
    }

    /*
     *  新規ゲームIDを作成する
     * 
     *  return int $game_id
     */
    public function setNewGameId(){
        $confg = new configModel();

        $this->game_id = $confg->setNewLastGameId();
        $this->gameState->setGameId($this->game_id);
        $this->gameModel->setNewGame($this->game_id);

        return $this->game_id;
    }

    /*
     *  現在のゲームIDを取得する
     * 
     *  return int $game_id
     */
    public function getGameId(){
        return $this->gameState->getGameId();
    }

    /*
     *  ユーザカードを指定し勝負。historyModelを返す
     * 
     *  return historyModel $history
     */
    public function Play($user_index)
    {
        //user 手札の選択
        $card_user = $this->gameState->getCardFromIndex($user_index,1);

        //cpu 手札の選択
        $card_cpu  = $this->cpuStoratege->getCard($this->gameState);
        
        if($card_user == null){
            throw new \Exception("user card is null");
        }
        if($card_cpu == null){
            throw new \Exception("cpu card is null");
        }

        $history = new historyModel();
        DB::beginTransaction();
        try {
            //勝負
            $history = $this->Battle($card_cpu,$card_user);

            //使ったカードを使用済みにする
            $this->gameState->removeCardByIndex($user_index,1);
            $this->cpuStoratege->afterPlay($card_cpu,$this->gameState);

            $cards = $this->gameState->getCardRemain();
            $this->gameState->setCardState($cards);
            DB::commit();
        } catch (\Exception $e) {
            DB::rollback();
        }

    return $history;

    }

    /*
     *  ユーザカードとCPUカードを指定し勝負し、historyModelを返す
     * 
     *  return historyModel $history
     */
    public function Battle(cardModel $card_cpu,cardModel $user_card)
    {
        $this->gameModel = GameModel::find($this->getGameId());
        $game_no = $this->gameModel->addGameNo($this->getGameId());
        session::put('game_no',$game_no);
        $point  = $this->checkPlay($card_cpu->no,$user_card->no);

        $this->historyModel->add($this->getGameId(),$game_no,$user_card->no,$user_card->color,$card_cpu->no,$card_cpu->color,$point);
        $history = $this->historyModel->getOne($this->getGameId(),$game_no);
        $history_0 = $this->historyModel->getOne($this->getGameId(),1);
        //$time      = ($history_0->created_at->diffInSeconds($history->created_at));
        //toukei1Model::add($history_0->created_at,$history->created_at);
        toukei2Model::add($user_card->no,$point);


        return $history;
    }

    /*
     *  ユーザカードとCPUカードを比較し、ポイントを返す
     * 
     *  return int $point
     */
    public function checkPlay(int $card_cpu,int $user_card){
        if ($card_cpu < $user_card) {
            return 1;
        } elseif ($card_cpu > $user_card) {
            return -1;
        } elseif ($card_cpu == $user_card) {
            return 0;
        }
        return 0;
    }

    /*
     *  カードをシャッフルし、シャッフルしたカードを返す
     * 
     *  return int $point
     */
    public function shuffle_card()
    {
        for ($c=1;$c<=4;$c++) {
            for ($i=1;$i<=13;$i++) {
                $cards[]= [ 'no'    => $i,
                            'color' => $c];
            }
        }
        shuffle($cards);
        $cards = array_slice($cards,0,13);

        return $cards;
    }
}
