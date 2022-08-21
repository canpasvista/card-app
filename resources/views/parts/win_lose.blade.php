@if ($history->point == 1)
            <span style="color:red;">
                {{$history->user_card}} : 
                {{$history->cpu_card}}
                プレイヤーの勝ち
            </span><br/>
            @elseif ($history->point == -1)
            <span style="color:blue;">
                {{$history->user_card}} : 
                {{$history->cpu_card}}
                CPUの勝ち
            </span><br/>
            @elseif ($history->point == 0)
            <span style="color:gray;">
                {{$history->user_card}} : 
                {{$history->cpu_card}}
                引き分け
            </span><br/>
            @endif
