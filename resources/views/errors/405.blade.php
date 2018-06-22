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
            background-image: url('https://cdn.pixabay.com/photo/2016/07/22/16/29/fog-1535201_960_720.jpg');
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
    </style>
</head>
<body>
    <br><br><br><br><br><br>
    <div class="error-container">

        <center>
            <h1>Network Error<br></h1>
            <p>Due to network failure your project is not listed <br> Please try  again to add the project </p>
            <p>If this error ocuures several times, refresh your mobile Network <br>(Usually happens because of Internet Connection)
        </center>
        <p>If this is problem is not solved contact MAMA MICRO TECHNOLOGY </p>
        <h1>Thank you </h1>
        <br>
        <center>
            <a href="{{ URL::previous() }}" class="btn btn-success btn-lg">Click Here To Go Back!</a>
        </center>
    </div>
</body>
</html>