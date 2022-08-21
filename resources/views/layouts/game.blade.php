@inject('gs','App\Services\gameService')
<html>
<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <script   src="https://code.jquery.com/jquery-3.6.0.min.js"   integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="   crossorigin="anonymous"></script>
  </head>

  <body>
  <div class="container">
    @php
    @endphp

  @if (!empty(session('game_id')))
  <div class="row align-items-start">
    <div class="col">
      <a href="/">メイン</a>
    </div>
    <div class="col">
    <a href="/board?game_id={{session('game_id')}}">ボード</a>
    </div>
    <div class="col">
    <a href="/score?game_id={{session('game_id')}}">スコアを見る</a>
    </div>

    @if (Auth::user()?->id == 1)
    <div class="col">
    <a href="/history?game_id={{session('game_id')}}">履歴を見る</a>
    </div>
    <div class="col">
    <a href="/toukei?game_id={{session('game_id')}}">統計情報</a>
    </div>
    @endif
  </div>
  @endif
    
  </div>
    @yield('content')
  </body>
    @extends('js.play')
    @extends('js.board')
    @extends('js.newplay')
    @extends('js.login')
    @extends('js.logout')
    @extends('js.score')
</html>
