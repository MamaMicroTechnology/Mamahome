@extends('layouts.app')

@section('content')
<div class="col-md-12">
    <div class="col-md-12">
        <div class="panel panel-default" style="border-color:#337ab7">
            <div class="panel-heading text-center" style="background-color:#337ab7">
                <b style="color:white">Get Report</b>
            </div>
            <div class="panel-body">
             <form action="{{ URL::to('/') }}/monthlyreport" method="GET" enctype="multipart/form-data"> 
                    {{ csrf_field() }}
                    <div class="col-md-2">
                   <h4><b>Select Employees</b></h4>
                    <select class="form-control" name="user_id" required>
                      <option value="">--Employees--</option>
                      @foreach($users as $user)
                      <option value="{{$user->id}}">{{$user->name}}</option>
                      @endforeach
                    </select>
                 </div>
                <div class="col-md-2">
                 <h4><b>Select From Date</b></h4>
                    <input value="{{ isset($_GET['fromdate']) ? $_GET['fromdate'] : '' }}" type="date" name="fromdate"  style="width:100%;" required>
                </div>
                   

               <div class="col-md-2">
                   <h4><b>Select To Date</b></h4>
                   <input value="{{ isset($_GET['todate']) ? $_GET['todate'] : '' }}" type="date" name="todate" style="width:100%;" required>
                     
                   </textarea>
                 </div> 
  
                  <div class="col-md-2">
                   
                    <button type="submit"  class="form-control btn btn-primary" value="submi" style="margin-top:40px;">Fetch Report</button> 
                 </div> 

            </div>
            </form>
            <center><h2 style="color:green;">30 Days Mini Report</h2></center>
<table  class="table" border="1">
                <thead>
                    <tr>
                        
                        <th>Employee Name</th>
                        <th>Date of Joining</th>
                        <th>Added Projects</th>
                        <th>Added manufactures</th>
                        <th>Updated Projects</th>
                        <th>Enquiries</th> 
                        <th>Confirm  Enquiries</th>
                        <th>Converted  Enquiries</th>
                        <th>Confirm Orders</th>
                        <th>No Of Calls</th>

                    </tr>
                </thead>
          <?php $i=1; ?>
                  @foreach($users as $user)
                <tbody>
                   <td>{{$user->name}}</td>
                   <td>{{$user->created_at->format('d-m-y')}}</td>
                   <td>{{ $total[$user->id]['addproject']}}</td>
                   <td>{{ $total[$user->id]['addmanu']}}</td>
                   <td>{{$total[$user->id]['updateproject'] }}</td>
                   <td>{{$total[$user->id]['addenquiry'] }}</td>
                   <td>{{$total[$user->id]['confirm'] }}</td>
                   <td>{{$total[$user->id]['converted'] }}</td>
                   <td>{{$total[$user->id]['order'] }}</td>
                   <td>{{ $total[$user->id]['calls'] }}</td>
                   </tbody>
                  @endforeach
                   
                   </table>

        </div>
    </div>
</div>
</div>
@endsection