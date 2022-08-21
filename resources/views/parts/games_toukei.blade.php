@php
    for($i=1;$i<=13;$i++){
        $toukei[$i] = 0;
        $toukei_win[$i] = 0;
        $toukei_per_win[$i] = 0;
    }
    foreach ($games as $game){
        foreach ($game->histories as $history){
            $toukei[$history->user_card]++;
            if( $history->point == 1){
                $toukei_win[$history->user_card]++;
            }
            $toukei_per_win[$history->user_card] = $toukei_win[$history->user_card]/ $toukei[$history->user_card];
        }
    }
    @endphp

    <table border="1">
    <tr>
    <th style="padding:8px;width:100px;">カード</th>
    @php
    for($i=1;$i<=13;$i++){
    @endphp
        <td style="width:50px">{{$i}}</td>
    @php
    }
    @endphp
    </tr>
    <tr>
    <th style="padding:8px;width:100px;">使用回数</th>
    @php
    for($i=1;$i<=13;$i++){
    @endphp
        <td style="width:50px">{{$toukei[$i]}}</td>
    @php
    }
    @endphp
    </tr>
    <tr>
    <th style="padding:8px;width:100px;">勝ち回数</th>
    @php
    for($i=1;$i<=13;$i++){
    @endphp
        <td style="width:50px">{{$toukei_win[$i]}}</td>
    @php
    }
    @endphp
    </tr>
    <tr>
    <th style="padding:8px;width:100px;">勝率</th>
    @php
    for($i=1;$i<=13;$i++){
    @endphp
        <td style="width:50px">{{number_format($toukei_per_win[$i],2)}}</td>
    @php
    }
    @endphp
    </tr>
</table>
    