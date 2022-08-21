@extends('layouts.game')

@section('content')
        @csrf
        @php
            $cards = json_decode(session('cards'));
            $history= json_decode(session('score_obj'));
            $game_id  = session('game_id');
            $game_no  = session('game_no');
            $game_state = session('game_state');
            $jwt      = session('jwt');
        @endphp
        @if (isset($game_id))
            試合番号{{$game_id}}
            @if (isset($history) )
            -{{$history->no}}
            <br/>
            <center>
            <img src="http://localhost:9000/img/{{$history->user_card_color}}/{{$history->user_card}}.png" style="width:96px;">
            <img src="http://localhost:9000/img/{{$history->cpu_card_color}}/{{$history->cpu_card}}.png" style="width:96px;">
            </center>
            @if ($history->user_card > $history->cpu_card)
            <input class="btn btn-primary" style="width:100%;" type="submit" value="勝ち">
            @elseif ($history->user_card < $history->cpu_card)
            <input class="btn btn-secondary" style="width:100%;" type="submit" value="負け">
            @elseif ($history->user_card == $history->cpu_card)
            <input class="btn btn-warning" style="width:100%;" type="submit" value="引き分け">
            @endif
            @endif
            <div class="container">
                <div class="row">
                @if (is_array($cards))
                @foreach ($cards as $key => $card)
                    <div class="col">
                        <div class="card" style="width: 8rem;border:none;">
                            <div class="card-body" style="text-align:center;">
                            <img src="http://localhost:9000/img/{{$card->color}}/{{$card->no}}.png" style="width:96px;">
                            <input class="btn btn-primary" style="width:100%;" type="submit" value="選択"  onClick="playCard({{$card->sort}})">
                            </div>
                        </div>
                    </div>
                @endforeach
                @endif
                </div>
            </div>

            <div class="container">
                <div class="mx-auto" style="width:340px;margin-top:160px;">
                @if ($game_state=='end')
                <br/><h3>終了</h3>
                <a href="#" onClick="api_new_play();">次の試合</a>
                <a href="/score" >スコアを見る</a>
                @endif
                </div>
            </div>



@endif
@endsection