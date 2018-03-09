<html>
    <head>
        <title>Buyer Login</title>
    </head>
    <body>
        <form method="POST" action="{{ URL::to('/') }}/buyerlogin">
            <input type="text" name="email" placeholder="Email"><br><br>
            <input type="password" name="password" placeholder="Password"><br><br>
            <input type="Submit" value="Login">
        </form>
    </body>
</html>