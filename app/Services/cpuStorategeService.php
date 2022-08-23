<?php

namespace App\Services;

use App\States\gameState;
use App\Models\gameModel;
use App\Models\configModel;
use App\Models\cardModel;
use App\Models\historyModel;

use Session;

class cpuStorategeService
{
    private $cpu_index;

    /*
     *  CPU用カード選択戦略
     * 
     *  return void
     */
    public function getCard(gameState $gameState){
        $items = [];
        $cards = $gameState->getCardRemain(0);

        foreach($cards as $card){
            $items[] = $card;
        }
        shuffle($items);
        return $items[0];
    }

    /*
     *  勝負後処理
     * 
     *  return void
     */
    public function afterPlay(
        cardModel $card_cpu,
        gameState $gameState
    ){
       //使ったカードを使用済みにする
        $gameState->removeCardByIndex($card_cpu->sort,0);
    }
}