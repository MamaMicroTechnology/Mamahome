@extends('layouts.app')
@section('content')
<div class="col-md-4">
     <div class="panel panel-primary">
            <div class="panel-heading">Quality Of Projects</div>
            <div id="piechart">
                
            </div>
        </div>
    <!-- <div class="panel panel-primary">
            <div class="panel-heading">Call Records</div>
            <div id="piechart2">
                
            </div>
    </div> -->
    <!-- <div class="panel panel-primary">
        <div class="panel-heading">Call Records</div>
        <div class="panel-body">
            @foreach($notes as $note)
            @if($note == null)
            WITHOUT NOTE - {{ $count[$note] }}<br>
            @else
            {{ $note }} - {{ $count[$note] }}<br>
            @endif
            @endforeach
        </div>
    </div> -->
       
</div>
<div class="col-md-8">
    <div class='col-md-12'>
        <div class="panel panel-default">
            <div class="panel-heading" style="background-color:green">
                <b style="color:white;text-align:center;font-size:1.3em">Quality of Projects</b>
                <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>
            </div>
            <div class="panel-body">
                <table class="table table-responsive table-hover">
                    <thead>
                        <tr>
                            <th>Listing Engineer</th>
                            <th>Quality of Project</th>
                            <th>From Date</th>
                            <th>To Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width:25%">
                                <select class="form-control" id="lename">
                                    <option value="" disabled selected>-- SELECT -- </option>
                                    <option value="ALL">All</option>
                                    @foreach($le as $list)
                                        <option value="{{$list->id}}">{{$list->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td style="width:25%">
                                <select class="form-control" id="qualityproj">
                                    <option value="ALL">All Projects</option>
                                    <option value="FAKE">Fake Projects</option>
                                    <option value="GENUINE">Genuine Projects</option>
                                     <option value="Unverified">Unverified Projects</option>
                                </select>
                            </td>
                            <td style="width:25%">
                                <input type="date" class="form-control" id="date1" name="date1" />
                            </td>
                            <td style="width:25%">
                                <input type="date" class="form-control" id="date2" name="date2" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <div class="text-center">
                    <a class="btn btn-md btn-success" name="submitque1ry" id="submitque1ry" style="width:50%" onclick="getquality()">Fetch Details</a>
                </div>
                <br>
                <div id="result"></div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
  ['Quality', 'In percentage'],
  ['Unverified :{{ $notConfirmed }} ', {{ $notConfirmed }}],
  ['Genuine : {{ $genuine }}', {{ $genuine }}]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {
      title:'Quality In Percentage',
      colors: ['#f9ff5e', '#5ee547', '#ec8f6e', '#f3b49f', '#f6c7b6']
      };

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>

<script src="http://code.jquery.com/jquery-3.3.1.js"></script>
<script type="text/javascript">
    var old_html;
    function getquality()
    {
        var e = document.getElementById("lename");
        var le_id = e.options[e.selectedIndex].value;
        var le_name = e.options[e.selectedIndex].text;
        var quality = document.getElementById("qualityproj");
        var qualityproj = quality.options[quality.selectedIndex].value;
        var date1 = document.getElementById("date1").value;
        var date2 = document.getElementById("date2").value;
        
        if(!le_id || !qualityproj || !date1 || !date2)
        {
            alert('Please Select All The Fields !!!');
            return false;
        }
        else
        {
            $.ajax({
                type: 'GET',
                url: '{{URL::to('/')}}/getquality',
                data: {id: le_id, quality: qualityproj, date1: date1, date2: date2},
                async:false,
                success:function(response)
                {
                    var result = "<div class='panel panel-primary'><div class='panel-heading' style='font-size:1.2em'>";
                    var times = new Array();
                    result += "<b>"+qualityproj + "</b> Projects - <b>"+le_name+"</b> From Date : <b>"+response[3]+"<b> To Date : <b>"+response[4]+"</b>";
                    result += "</b><b class='pull-right'>Total Count : "+response[2]+"</b></div>";
                    result += "<div class='panel-body'><label>Filter By Date : </label><select id='filtertime' class='form-control' name='filtertime' onchange='datefilter()'></select><br><table class='table table-responsive table-hover' id='prjectTable'><thead><tr><th style='text-align:center;width:10%'>Project ID</th><th style='text-align:center;width:30%'>Ward Name</th><th style='text-align:center;width:20%'>Date</th><th style='text-align:center;width:20%'>Time</th><th style='text-align:center;width:20%'>Contract</th></tr><tbody>";
                    for(var i=0; i<response[0].length;i++)
                    {
                        if(response[0][i].contract == null){
                            response[0][i].contract = ' --- ';
                        }
                        result += "<tr id='tr-"+response[0][i].project_id+"'><td style='text-align:center'>";
                        result += "<a href='";
                        result += '{{URL::to('/')}}/showThisProject?id='+response[0][i].project_id;
                        result += "'";
                        var date_1 = response[0][i].created_at;
                        var res = date_1.substr(0, 10);
                        var year = res.substr(0,4);
                        var month = res.substr(5, 2);
                        var day = res.substr(8,2);
                        var newres = day+"-"+month+"-"+year;
                        var res2 = date_1.substr(10,18);
                        times[i]= newres;
                        result += " target='_blank'>"+response[0][i].project_id+"</a></td><td style='text-align:center'>"+response[0][i].sub_ward_name+"</td><td id='date-"+response[0][i].project_id+"' style='text-align:center'>"+newres+"</td><td style='text-align:center'>"+res2+"</td><td style='text-align:center'>"+response[0][i].contract+"</td></tr>";
                    }
                    result +="</tbody></table><br>";
                    document.getElementById('result').innerHTML = result;
                    var unique = times.filter(function(elem, index, self) {
                        return index === self.indexOf(elem);
                    })
                    var options = new String();
                    for(var i=0;i<unique.length;i++)
                    {
                        options += "<option value = '";
                        options += unique[i];
                        options += "'>"+unique[i];
                        options += "</option>";
                    }
                    document.getElementById('filtertime').innerHTML = options;
                }
            });
            old_html = document.getElementById('result').innerHTML;
        }
        return false;
    }
    function datefilter() {
      var input, filter, table, tr, td, i;
      input = document.getElementById("filtertime");
      filter = input.value.toUpperCase();
      table = document.getElementById("prjectTable");
      tr = table.getElementsByTagName("tr");
      for (i = 0; i < tr.length; i++) {
        td = tr[i].getElementsByTagName("td")[2];
        if (td) {
          if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
            tr[i].style.display = "";
          } else {
            tr[i].style.display = "none";
          }
        }       
      }
    }
</script>

<script type="text/javascript">
// Load google charts
google.charts.load('current', {'packages':['corechart']});
google.charts.setOnLoadCallback(drawChart);

// Draw the chart and set the chart values
function drawChart() {
  var data = google.visualization.arrayToDataTable([
    ['Call Notes', 'In percentage'],
    @foreach($notes as $note)
    @if($note == null)
    ['WITHOUT NOTE : {{ $count[$note] }}', {{ $count[$note] }}],
    @else
    ['{{ $note }} : {{ $count[$note] }}', {{ $count[$note] }}],
    @endif
    @endforeach
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Call Records'};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart2'));
  chart.draw(data, options);
}
</script>

@endsection