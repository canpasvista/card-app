<script>
        @php
        $jwt = session('jwt');
        @endphp
function api_new_play() {
    token = "{{$jwt}}";
    $.ajax({
            type: 'get',
            url: 'http://localhost/api/openboard',
            dataType: 'json',
            beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization', 'Bearer ' + token); }
        })
        .done((data) => {
            console.log(data.game_id);
            if( data.game_id)
                window.location.href = "/board?game_id="+data.game_id;
        })
        .fail((data) => {
            console.log(data);
            //window.location.href = "/play";
        });
};
</script>