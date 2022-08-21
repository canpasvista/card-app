@extends('layouts.game')

@section('content')
<center>
    @php
    $game_id = session('game_id');
    @endphp
@foreach ($games as $game)
    @php
    $n=0;
    $siai = "第".$game->game_id."試合";
    @endphp
    <div style="margin-top:16px;">
            <div class="box_head"></div>
            <div class="box_content">{{$siai}} <a href="/api/deletehistory?game_id={{$game->game_id}}">削除する</a></div>
    </div>
    @foreach ($game->histories as $history)
    @php
    $n++;
    @endphp
        <div>
            <div class="box_head"></div>
            <div class="box_content">{{$n}}回戦　
            @include('parts.win_lose', ['history' => $history])</div>
        </div>
    @endforeach
    @endforeach
    <div style="margin-left:auto;margin-right:auto;">
        
    <ul class="pagination" style="width:60vw">
        @php
        $have_first = false;
        $active = "";
        $lastPage = $games->lastPage();
        for($p=1;$p<=10&&$p<=$lastPage;$p++){
            if( $page > 7 && $p > 2){
                $have_first = true;
                break;
            }
            if( $p == $page)$active ="active";
            else $active = "";
        @endphp
        <li class="page-item {{$active}}">
        <a class="page-link" href='/history?game_id={{$game_id}}&page={{$p}}'>{{$p}}</a>
        </li>
        @php
        }
        if( $have_first)echo "...";
        $have_last = false;
        if( $p == $lastPage ){
        if( $page >=8){
            $p = $page-3;
        }
        else if( $page >= $lastPage-9){
            $p = $lastPage -9;
        }
        }
        for($p;$p<=$page+3&&$p<$lastPage;$p++){
            if( $p == $page)$active ="active";
            else $active = "";
        @endphp
        <li class="page-item {{$active}}">
        <a class="page-link" href='/history?game_id={{$game_id}}&page={{$p}}'>{{$p}}</a>
        </li>
        @php
        }
        if( $p <= $lastPage ){
        if( $page <= $lastPage-7){
            $p = $lastPage -1;
            $have_last = true;
        }
        if( $have_last )echo "...";
        for($p;$p<=$lastPage;$p++){
            if( $p == $page)$active ="active";
            else $active = "";
        @endphp
        <li class="page-item {{$active}}">
        <a class="page-link" href='/history?game_id={{$game_id}}&page={{$p}}'>{{$p}}</a>
        </li>
        @php
        }
    }
        @endphp
    </div>
    </center>
    <style>
        .pagination{
            justify-content: center;
            margin-top:1em;
        }
        .box_head{
            width:140px;
            display: inline-block;
        }
        .box_content{
            width:320px;
            display: inline-block;
            text-align:left;
        }
    </style>
@endsection