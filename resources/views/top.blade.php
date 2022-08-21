@extends('layouts.game')

@section('content')
@php
$game_id = session('game_id');
$game_no = session('game_no');
$jwt     = session('jwt');
@endphp
  @if (0)
  @if (Route::has('login'))
                <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
                    @auth
                        <a href="{{ url('/home') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">管理画面</a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="ml-4 text-sm text-gray-700 dark:text-gray-500 underline">Register</a>
                        @endif
                    @endauth
                </div>
                @endif
    @endif
  <div class="container">
    <div class="mx-auto" style="width:340px;margin-top:160px;">
    <h1>カードゲーム</h1>
    <h3>説明</h3>
    <div>カードが配られます。<br/>
      配られたカードから１枚選択。<br/>
      CPUが出したカードと比べ数値の大きかった方の勝ち。<br/>
      カードがなくなるまで繰り返します。<br/>
    <br/><br/>
    </div>
    @php
    $jwt = session('jwt');
    @endphp
    @if (!empty($jwt))
        <form method="get" action="/api/start?access_token={{$jwt}}">
        <!-- フォームのコンテンツ -->
        @csrf
        <input  class="btn btn-primary" style="width:340px;" type="button" onClick="api_new_play()" value="始める">
        </form>
    @endif
    @if (empty($jwt))
    E-Mail : <input type="text" id="id" value="test@test.com"><br>
    PASSWORD : <input type="text" id="password" value="test1234"><br>
    <input  class="btn btn-primary" style="width:340px;" type="button" onClick="login()" value="login">
    @endif
    @if (!empty($jwt))
    <input  class="btn btn-primary" style="width:340px;" type="button" onClick="logout()" value="logout">
    @endif
</div>
</div>

@endsection

@section('js')
@endsection
