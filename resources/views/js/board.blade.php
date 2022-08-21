<script>
        @php
        $jwt = session('jwt');
        @endphp
function api_board() {
    token = "{{$jwt}}";
    $.ajax({
            type: 'get',
            url: 'http://localhost/board',
            dataType: 'json',
            beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization', 'Bearer ' + token); }
        })
        .done((data) => {
            console.log(data);
            $('body').html(data.responseText);
        })
        .fail((data) => {
            console.log(data);
            $('body').html(data.responseText);
        });
};
function api_history() {
    token = "{{$jwt}}";
    $.ajax({
            type: 'get',
            url: 'http://localhost/api/history',
            dataType: 'json',
            beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization', 'Bearer ' + token); }
        })
        .done((data) => {
            console.log(data);
            $('body').html(data.responseText);
        })
        .fail((data) => {
            console.log(data);
            $('body').html(data.responseText);
        });
};

</script>