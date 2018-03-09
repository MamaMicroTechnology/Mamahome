<html>
    <head>
        <title>Forgor Password</title>
    </head>
    <body>
        <form method="POST" action="{{ URL::to('/') }}/forgot">
            {{ csrf_field() }}
            <input type="text" name="id">
            <input type="password" name="newpassword">
            <input type="submit">
        </form>
    </body>
</html>