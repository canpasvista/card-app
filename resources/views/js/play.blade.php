@php
    $jwt = session('jwt');
    $game_id = session('game_id');
@endphp

<script>

@if (!empty($game_id))
function playCard(card) {
    token = "{{$jwt}}";
    var data = {
        game_id:{{$game_id}},
        card: card,
    };
    $.ajax({
            type: 'get',
            url: 'http://localhost/api/playcard',
            dataType: 'json',
            data: data,
            beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization', 'Bearer ' + token); }
        })
        .done((data) => {
            console.log(data);
            window.location.href = "/board";
        })
        .fail((data) => {
            console.log(data);
            //window.location.reload();
            $('body').html(data.responseText);
        });
}
@endif

</script>