<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>My Profile</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <style>
        img{
            border-radius: 50%;
            height: 150px;
            width: 150px;
        }
    </style>
</head>
<body>
    <br>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <center>
                        <img id="disp" src="{{ URL::to('/') }}/public/profilePic/{{ Auth::user()->profilepic }}">
                    <br>
                    <br>
                    <form method="POST" action="{{ URL::to('/') }}/uploadProfilePicture" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="input-group col-md-6">
                        <input oninput="display()" id="pp" required type="file" class="form-control" name="pp" accept="image/*">
                        <div class="input-group-btn">
                          <button class="btn btn-default" type="submit">
                            Submit
                          </button>
                        </div>
                      </div>
                    </form>
                    <br>
                    <h2>{{ Auth::user()->name }}</h2>
                    <h3>{{ Auth::user()->department_id }}</h3>
                </center>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
    <script>
          $(function(){
  $('#pp').change(function(){
    var input = this;
    var url = $(this).val();
    var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
    if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
     {
        var reader = new FileReader();

        reader.onload = function (e) {
           $('#disp').attr('src', e.target.result);
        }
       reader.readAsDataURL(input.files[0]);
    }
    else
    {
      $('#disp').attr('src', '/assets/no_preview.png');
    }
  });

});
    </script>
</body>
</html>