@extends('layouts.game')

@section('content')
<center>
<br><br>
    <table border="1">
    <tr>
    <th style="padding:8px;width:100px;">試合時間</th>
    @foreach ($toukei1 as $obj)
        <td style="width:50px">{{$obj->time}}秒</td>
    @endforeach
    </tr>
    <tr>
        <th style="padding:8px;width:100px;">回数</th>
    @foreach ($toukei1 as $obj)
        <td style="width:50px">{{$obj->cnt}}</td>
    @endforeach
    </tr>
    </table>
    <br><br>
    <table border="1">
    <tr>
        <th style="padding:8px;width:100px;">カード番号</th>
    @foreach ($toukei2 as $obj)
        <td style="width:50px">{{$obj->no}}</td>
    @endforeach
        </tr>
        <tr>
        <th style="padding:8px;width:100px;">使用回数　</th>
    @foreach ($toukei2 as $obj)
       <td style="width:50px">{{$obj->use}}</td>
    @endforeach
        </tr>
        <tr>
        <th style="padding:8px;width:100px;">勝ち回数　</th>
    @foreach ($toukei2 as $obj)
       <td style="width:50px">{{$obj->win}}</td>
    @endforeach
        </tr>
        <tr>
        <th style="padding:8px;width:100px;">勝率回数　</th>
    @foreach ($toukei2 as $obj)
       <td style="width:50px">{{$obj->perwin}}</td>
    @endforeach
        </tr>
    </table>
    </center>
@endsection