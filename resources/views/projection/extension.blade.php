<?php
    $group = Auth::user()->group->group_name;
    if($group == "Auditor"){
        $content = "auditor.layout.auditor";
    }else{
        $content = "layouts.app";
    }
?>
@extends($content)
@section('content')
<div class="col-md-6 col-md-offset-3">
            <form action="" method="get">
                <div class="form-group">
                <label style="text-align:left;" for="number" class="control-label col-sm-6">Enter The Number Of Months To Extend Your Business</label>
                <div class="col-md-4">
                    <input type="text" name="number" value="{{ isset($_GET['number']) ? $_GET['number'] : ''}}" id="number" placeholder="Number Of Months" class="form-control input-sm">
                </div>
                <div class="col-md-2">
                    <input type="submit" class="form-control btn btn-success input-sm" value="Get">
                </div>
            </form>
            <br>
                @if(isset($_GET['number']))
                @if($dates == null)
                
                        <script>
                            swal("error","First You Have To Lock The Target With Monthly Sales Projection.","error");
                        </script>
                @else
                <form action="{{ URL::to('/') }}/save" method="POST">
                    {{ csrf_field() }}
                    <table class="table table-hover" border=1>
                        <thead>
                            <tr><th colspan=6><center>Expansion Plan</center></th></tr>
                            <tr>
                                <th rowspan=3 style="text-align:center">Month<br><br></th>
                            </tr>
                            <tr>
                                <th colspan="5" style="text-align:center">Wards</th>
                            </tr>
                            <tr>
                                <th style="text-align:center">Grade A</th>
                                <th style="text-align:center">Grade B</th>
                                <th style="text-align:center">Grade C</th>
                                <th style="text-align:center">Grade D</th>
                                <th style="text-align:center">Grade E</th>
                            </tr>
                        </thead>
                        <tbody>
                            @for($i = 0; $i < $_GET['number']; $i++)
                                <tr>
                                    <input type="hidden" value="{{ date('M-Y',strtotime("+" . $i . " months", strtotime($dates->from_date))) }}" name="month[]">
                                    <td style="text-align:center">{{ date('M-Y',strtotime("+" . $i . " months", strtotime($dates->from_date))) }}</td>
                                    <td><input type="text" oninput="check()" value="{{ isset($_GET['edit']) ? $projections[$i]['grade_a'] : '0' }}" name="gradeA[]" id="" class="form-control"></td>
                                    <td><input type="text" oninput="check()" value="{{ isset($_GET['edit']) ? $projections[$i]['grade_b'] : '0' }}" name="gradeB[]" id="" class="form-control"></td>
                                    <td><input type="text" oninput="check()" value="{{ isset($_GET['edit']) ? $projections[$i]['grade_c'] : '0' }}" name="gradeC[]" id="" class="form-control"></td>
                                    <td><input type="text" oninput="check()" value="{{ isset($_GET['edit']) ? $projections[$i]['grade_d'] : '0' }}" name="gradeD[]" id="" class="form-control"></td>
                                    <td><input type="text" oninput="check()" value="{{ isset($_GET['edit']) ? $projections[$i]['grade_e'] : '0' }}" name="gradeE[]" id="" class="form-control"></td>
                                </tr>    
                            @endfor
                            <tr>
                                <th>Total</th>
                                <th id="totalA"></th>
                                <th id="totalB"></th>
                                <th id="totalC"></th>
                                <th id="totalD"></th>
                                <th id="totalE"></th>
                            </tr>
                        </tbody>
                    </table>
                    <input type="submit" value="Save" class="form-control btn btn-primary">
                </form>
                @endif
                @endif
            </div>
        </div>
        <script>
    function check(){
        var totalA = 0;
        var totalB = 0;
        var totalC = 0;
        var totalD = 0;
        var totalE = 0;

        var a_grades = document.getElementsByName("gradeA[]");
        var b_grades = document.getElementsByName("gradeB[]");
        var c_grades = document.getElementsByName("gradeC[]");
        var d_grades = document.getElementsByName("gradeD[]");
        var e_grades = document.getElementsByName("gradeE[]");
        
        for(var i = 0; i < a_grades.length; i++){
            if(a_grades[i].value != ""){
                totalA += parseInt(a_grades[i].value);
            }
        }

        for(var i = 0; i < b_grades.length; i++){
            if(b_grades[i].value != ""){
                totalB += parseInt(b_grades[i].value);
            }
        }
        for(var i = 0; i < c_grades.length; i++){
            if(c_grades[i].value != ""){
                totalC += parseInt(c_grades[i].value);
            }
        }
        for(var i = 0; i < d_grades.length; i++){
            if(d_grades[i].value != ""){
                totalD += parseInt(d_grades[i].value);
            }
        }
        for(var i = 0; i < e_grades.length; i++){
            if(e_grades[i].value != ""){
                totalE += parseInt(e_grades[i].value);
            }
        }

        if(totalA <= 40){
            document.getElementById('totalA').innerHTML = totalA;
        }
        else{
            alert("You have exceeded maximum number of zones");
            a_grades[a_grades.length - 1].value="";
        }

        if(totalB <= 60){
            document.getElementById('totalB').innerHTML = totalB;
        }
        else{
            alert("You have exceeded maximum number of zones");
            b_grades[b_grades.length - 1].value="";
        }

        if(totalC <= 60){
            document.getElementById('totalC').innerHTML = totalC;
        }
        else{
            alert("You have exceeded maximum number of zones");
            c_grades[c_grades.length - 1].value="";
        }

        if(totalD <= 25){
            document.getElementById('totalD').innerHTML = totalD;
        }
        else{
            alert("You have exceeded maximum number of zones");
            d_grades[d_grades.length -1].value="";
        }

        if(totalE <= 25){
            document.getElementById('totalE').innerHTML = totalE;
        }
        else{
            alert("You have exceeded maximum number of zones");
            e_grades[e_grades.length -1].value="";
        }
    }
</script>
@endsection