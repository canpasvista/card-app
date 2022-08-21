@extends('layouts.game')

@section('content')
@php
    //$historys    = json_decode(session('scores'));
    $game_id  = session('game_id');
@endphp
@if (isset($game_id) && count($historys) > 0)
<div class="container">
    <div class="mx-auto" style="width:340px;margin-top:120px;">
        @php
            $n = 1;
            $point = 0;
            $total = 0;
            foreach($historys as $history){
                if( $history->point == 1)$point++;
                $total += $history->point;
            }
        @endphp
        <div>試合番号{{$game_id}}</div>
        <h1>スコア</h1>
        @if ($total > 0)
        <h3>勝者　プレイヤー</h3>
        @elseif ($total < 0)
        <h3>勝者　CPU</h3>
        @elseif ($total == 0)
        <h3>引き分け</h3>
        @endif
        <h5>{{$point}}ポイント</h5> <br/>

        @foreach ($historys as $history)
            {{$n}}回戦　
            @include('parts.win_lose', ['history' => $history])
            @php
                $n++;
            @endphp

        @endforeach
    </div>
</div>
@endif

<script>
        @php
        $jwt = session('jwt');
        @endphp
        function api_score(){
            token = "{{$jwt}}";
            $.ajax( {
            type: 'get',
            url: 'http://localhost/api/score',
            dataType: 'json',
            beforeSend: function( xhr, settings ) { xhr.setRequestHeader( 'Authorization', 'Bearer '+ token ); }
            } )
            .done( ( data ) => {
                console.log(data);
                $('body').html(data.responseText);
            } )
            .fail( ( data ) => {
                console.log(data);
                $('body').html(data.responseText);
             } );
        };
</script>

@endsection