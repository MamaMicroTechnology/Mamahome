@extends('layouts.app')
@section('content')
<div class="col-md-4 col-md-offset-4">
    <form>
        <!-- <input placeholder="Number" required class="form-control" type="tel" name="number" id="number"><br> -->
        <select name="" id="number" class="form-control" multiple>
            <option value="919591418307">9591418307</option>
            <option value="918123399945">8123399945</option>
            <option value="919986450203">9986450203</option>
        </select>
        <textarea placeholder="SMS Content" required name="content" class="form-control" id="content" cols="30" rows="10"></textarea><br>
        <button onclick="sendSms()" class="btn btn-success form-control" type="button">Send</button>
    </form>
</div>

<script>
    function sendSms(){
        var xhr = new XMLHttpRequest();
        var number = document.getElementById('number');
        var content = document.getElementById('content').value;
        var selected = [];
        for(var i = 0;i<number.options.length; i++){
            if(number.options[i].selected){
                // selected.push(number.options[i].value);
                if(content != ""){
                    xhr.open("GET", "https://platform.clickatell.com/messages/http/send?apiKey=eOQt-oytSayA_9PKYtpBAw==&to=" + number.options[i].value + "&content=" + content, true);
                    xhr.onreadystatechange = function(){
                        if (xhr.readyState == 4 && xhr.status == 200){
                            console.log('success')
                        }
                    };
                    xhr.send();
                }else{
                    alert('Error');
                }
            }
        }
    }
</script>
@endsection