<script>
@php
$jwt = session('jwt');
@endphp
function api_score() {
    token = "{{$jwt}}";
    $.ajax({
            type: 'get',
            url: 'http://localhost/api/score',
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