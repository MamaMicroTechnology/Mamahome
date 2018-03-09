@extends('layouts.app')
@section('content')

<div class="col-md-12">
    <div id="piechart"></div>
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
  ['Initiated : {{ $initiate }} ', {{ $initiate }}],
  ['Placed : {{ $placed }}', {{ $placed }}],
  ['Confirmed : {{ $confirmed }}', {{ $confirmed }}],
  ['Cancelled : {{ $cancelled }}', {{ $cancelled }}]
]);

  // Optional; add a title and set the width and height of the chart
  var options = {'title':'Orders', 'width':700, 'height':450};

  // Display the chart inside the <div> element with id="piechart"
  var chart = new google.visualization.PieChart(document.getElementById('piechart'));
  chart.draw(data, options);
}
</script>
@endsection
