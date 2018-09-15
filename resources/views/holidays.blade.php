@extends('layouts.app')
@section('content')
<div class="col-md-6 col-md-offset-3">
<table class="table" border="1px;">
    <thead>
       <tr>
        <th colspan="5" style="text-align: center;">Holiday List for 2018</th>
      </tr>
      <tr>
        <th>SL. NO.</th>
        <th>Date</th>
        <th>Day</th>
        <th>Holiday</th>
        <th></th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <td>1</td>
        <td>Friday, January 26, 2018</td>
        <td>Friday</td>
        <td>Republic Day</td>
        <td>NH</td>
      </tr>
      <tr>
        <td>2</td>
        <td>Sunday, March 18, 2018</td>
        <td>Sunday</td>
        <td>Ugadi</td>
        <td>FH</td>
      </tr>
      <tr>
        <td>3</td>
        <td>Friday, March 30, 2018</td>
        <td>Friday</td>
        <td>Good Friday</td>
        <td>FH</td>
      </tr>
      <tr>
        <td>4</td>
        <td>Tuesday, May 01, 2018</td>
        <td>Tuesday</td>
        <td>May Day</td>
        <td>NH</td>
      </tr>
      <tr>
        <td>5</td>
        <td>Friday, June 15, 2018</td>
        <td>Friday</td>
        <td>Ramzann</td>
        <td>FH</td>
      </tr>
      <tr>
        <td>6</td>
        <td>Wednesday, August 15, 2018</td>
        <td>Wednesday</td>
        <td>Independence Day</td>
        <td>NH</td>
      </tr>
      <tr>
        <td>7</td>
        <td>Wednesday, August 22, 2018</td>
        <td>Wednesday</td>
        <td>Bakrid</td>
        <td>FH</td>
      </tr>
      <tr>
        <td>8</td>
        <td>Thursday, September 13, 2018</td>
        <td>Thursday</td>
        <td>Ganesha Chaturthi</td>
        <td>FH</td>
      </tr>
      <tr>
        <td>9</td>
        <td>Wednesday, November 07, 2018</td>
        <td>Wednesday </td>
        <td>Deepavali</td>
        <td>FH</td>
      </tr>
      <tr>
        <td>10</td>
        <td>Tuesday, December 25, 2018</td>
        <td>Tuesday</td>
        <td>Christmas Day</td>
        <td>FH</td>
      </tr>
    </tbody>
  </table>
  <table class="table" border="1px;">
    <tr>
        <td>FH</td>
        <td colspan="2">Festival Holiday</td>
        <td>7</td>
       
      </tr>
      <tr>
        <td>NH</td>
        <td colspan="2">National Holiday</td>
        <td >3</td>
       
      </tr>
  </table>
</div>

@endsection