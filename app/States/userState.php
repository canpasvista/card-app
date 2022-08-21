<?php

namespace App\States;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use Session;

class userState
{
    public function setMessage(string $message){
        session(['message'=> $message]);
    }
    public function clearMessage(){
        session(['message'=> '']);
    }
    public function setCPUCard(int $cpu_card){
        session(['cpu_card'=> $cpu_card]);
    }
    public function setUserCard(int $user_card){
        session(['user_card'=> $user_card]);
    }
    public function setScore($score){
        session(['score_obj'=> $score]);
    }
    public function setScores(string $score){
        session(['scores'=> $score]);
    }
}
