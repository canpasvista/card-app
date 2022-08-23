<script>
        @php
        $jwt = session('jwt');
        @endphp
function logout() {
    token = "{{$jwt}}";
    $.ajax({
            type: 'get',
            url: 'http://localhost/logout2',
            dataType: 'json',
            beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization', 'Bearer ' + token); }
        })
        .done((data) => {
            console.log(data);
            window.location.reload();
        })
        .fail((data) => {
            console.log(data);
            window.location.reload();
        });
};

</script>