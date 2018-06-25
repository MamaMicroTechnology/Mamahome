<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Error</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <style>
        body{
            background-image: url('https://mamahome360.com/webapp/errorBackground.jpg');
            background-size: cover;
        }
        .error-container{
            padding: 40px;
            border-radius: 5px;
            background-color: rgba(123,123,123,0.5);
            width: 50%;
            margin: auto;
            color:white;
        }
        .error-container h1{
            font-size: 70px;
        }
        @media only screen and (max-width: 600px) {
            .error-container{
                padding: 40px;
                border-radius: 5px;
                background-color: rgba(123,123,123,0.5);
                width: 90%;
                margin: auto;
                color:white;
            }
            body{
                background-repeat: no-repeat;
                background-size: auto;
            }
        }
    </style>
</head>
<body>
    <br><br><br><br><br><br>
    <div class="error-container">
        <center>
            <h1>403<br></h1>
            <p>Access Forbidden</p>
        </center>
        <br>
        <center>
            <a href="{{ URL::previous() }}" class="btn btn-success btn-lg">Click Here To Go Back!</a>
        </center>
    </div>
</body>
</html>