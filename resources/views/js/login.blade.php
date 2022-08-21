<script>
function login() {
    var data = {
        email: $('#id').val(),
        password: $('#password').val()
    };
    console.log(data);
    $.ajax({
            type: 'post',
            url: 'http://localhost/api/auth/login',
            dataType: 'json',
            data: data,
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