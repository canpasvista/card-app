<script>
        @php
        $jwt = session('jwt');
        @endphp
function logout() {
    token = "{{$jwt}}";
    $.ajax({
            type: 'post',
            url: 'http://localhost/api/auth/logout',
            dataType: 'json',
            beforeSend: function(xhr, settings) { xhr.setRequestHeader('Authorization', 'Bearer ' + token); }
        })
        .done((data) => {
            console.log(data);
            window.location.reload();
        })
        .fail((data) => {
            console.log(data);
            //window.location.reload();
        });
};

</script>