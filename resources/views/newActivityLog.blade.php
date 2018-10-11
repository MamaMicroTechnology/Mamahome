@extends('layouts.app')
@section('content')
    <div class="col-md-3">
        <div class="panel panel-primary" style="overflow-x:scroll">
            <div class="panel-heading text-center">
                <b style="color:white">Custom Daily Slot</b>
            </div>
            <div class="panel-body">
                <form action="{{ URL::to('/') }}/newActivityLog" method="GET">
                     {{ csrf_field() }}
                <table class="table table-responsive">
                    <tbody >
                        <tr>
                            <td>Select Listing Engineer</td>
                        </tr>
                        <tr>
                            <td>
                                <select class="form-control" name="list" required>
                                    <option disabled selected value="">(-- SELECT LE --)</option>
                                    @if(Auth::user()->group_id != 22)
                                    @foreach($users as $list)
                                    <option value="{{$list->id}}">{{$list->name}}</option>
                                    @endforeach
                                    @endif
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Select From Date</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="date" placeholder= "From Date" class="form-control" id="fromdate" name="fromdate" required />
                            </td>
                        </tr>
                        <tr>
                            <td>Select To Date</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="date"  placeholder= "To Date" class="form-control" id="todate" name="todate" required />
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>
                                <button type="submit" class="btn bn-md btn-success" style="width:100">Get Date Range Details</button>
                            </td>
                        </tr>
                        <!--<tr class="text-center">-->
                        <!--    <td>-->
                        <!--        <a class="btn bn-md btn-primary" style="width:100%" onclick="showtodayrecordsle()">Get Date Details</a>-->
                        <!--    </td>-->
                        <!--</tr>-->
                    </tbody>
                </table>
            </form>
            </div>
        </div>
        <div class="panel panel-default" styke="border-color:green">
            <div class="panel-heading text-center" style="background-color:green">
                <b style="color:white">Mini Report (Today)</b>
            </div>
            <div class="panel-body" style="overflow-x:scroll;">
                <table class="table table-striped" border="1">
                    <thead>
                        <th style="font-size: 10px;">Name</th>
                        <th style="font-size: 10px;">Updated Projects</th>
                        <th style="font-size: 10px;">Called Projects</th>
                        <th style="font-size: 10px;">With Out Called Projects</th>
                    </thead>
                    @foreach($users as $user)
                    <tr>
                        <td style="font-size: 10px;">{{ $user->name }}</td>
                        <td style="font-size: 10px;">{{$noOfCall[$user->id]['count']}}</td>
                        <td style="font-size: 10px;">{{$noOf[$user->id]['history']}}</td>
                      <?php 
                      $x = $noOfCall[$user->id]['count'] - $noOf[$user->id]['history'];
                       ?>
                        <td style="font-size: 10px;">{{$x}}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-9" >
        <div class="panel panel-primary" style="overflow-x:scroll">
            <div class="panel-heading" id="panelhead" style="padding:25px;">
                 <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color:black;"></i></button> 
            </div>
            <div class="panel-body">
                <table class='table table-responsive table-striped' style="color:black" border="1">
                    <thead>
                        <tr>
                            <!-- <th style="text-align:center">Activity Id</th>  -->
                            <th style="text-align:center">User Name</th> 
                            <th style="text-align:center">Subward Ward Name</th>
                            <th style="text-align:center">Project-ID</th>
                            <th style="text-align:center">Project Description</th>
                            <!-- <th style="text-align:center">Project Status</th> -->
                            <th style="text-align:center">Called Status</th>
                        </tr>
                    </thead>
                    <tbody id="mainPanel">
                    @foreach($users as $user)
                    @foreach($noOfCalls[$user->id]['data'] as $activities)
                        <tr>
                               <!-- <td style="text-align:center" >{{$activities->id}}</td> -->
                            <td style="text-align:center" >{{$user->name}}</td>
                            @foreach($sub as $subward)
                               @if($activities->subject->sub_ward_id == $subward->id)
                               <td style="text-align:center" >
                                {{ $subward->sub_ward_name != null ? $subward->sub_ward_name :''}}
                               </td>
                               @endif
                               @endforeach
                            <td style="text-align:center">{{ $activities->subject->project_id }}</td>
                            <?php
                            $data =json_decode($activities->changes(), TRUE);
                            ?>
                              <td style="text-align:center">{{ $activities->properties }}</td>
                              <!-- <td style="text-align:center">{{ $activities->description }}</td> -->
                              <td style="text-align:center">
                                  @if($called[$user->id] == 0)
                                        NO
                                  @else
                                     Yes
                                  @endif         
                              </td>
                        </tr>
                        @endforeach
                    @endforeach    
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="http://code.jquery.com/jquery-3.3.1.js"></script>
    
    <script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
     background-color: #00acd6 

});

</script>
@endsection
