@if ($history->point == 1)
            <span style="color:red;">
                <div style="display:inline-block;width:70px;">　
                {{$history->user_card}} : 
                {{$history->cpu_card}}
                </div>
                勝ち
            </span><br/>
            @elseif ($history->point == -1)
            <span style="color:blue;">
            <div style="display:inline-block;width:70px;">　
                {{$history->user_card}} : 
                {{$history->cpu_card}}
                </div>
                負け
            </span><br/>
            @elseif ($history->point == 0)
            <span style="color:gray;">
            <div style="display:inline-block;width:70px;">　
                {{$history->user_card}} : 
                {{$history->cpu_card}}
                </div>
                引き分け
            </span><br/>
            @endif
