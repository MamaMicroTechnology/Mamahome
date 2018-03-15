@extends('layouts.app')
@section('content')

<div class="col-md-6">
    <div class="panel panel-warning">
      <div class="panel-heading">Sales Statistics</div>  
      <div id="piechart">
        
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
  ['Pipelined : {{ $notProcessed }}', {{ $notProcessed }}],
  ['Initiated : {{ $initiate }} ', {{ $initiate }}],
  ['Placed : {{ $placed }}', {{ $placed }}],
  ['Confirmed : {{ $confirmed }}', {{ $confirmed }}],
  ['Cancelled : {{ $cancelled }}', {{ $cancelled }}]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Orders','height':450};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>

@endsection