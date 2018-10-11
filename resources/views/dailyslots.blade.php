@extends('layouts.app')
@section('content')
    <div class="col-md-3">
        <div class="panel panel-primary" style="overflow-x:scroll">
            <div class="panel-heading text-center">
                <b style="color:white">Custom Daily Slot</b>
            </div>
            <div class="panel-body">
                <form action="{{ URL::to('/') }}/dailyslots" method="GET">
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
                                    
                                    <option value="ALL">All Listing Engineers</option>
                                    @if(Auth::user()->group_id != 22)
                                    @foreach($le as $list)
                                    <option value="{{$list->id}}">{{$list->name}}</option>
                                    @endforeach
                                    @else
                                    @foreach($tlUsers as $list)
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
                <b style="color:white">Mini Report of listing engineer  (Today)</b>
            </div>
            <div class="panel-body" style="overflow-x:scroll;">
                 @if(Auth::user()->group_id != 22)
                <label style="color:black">Total Projects Added = <b>{{$lcount}}</b></label><br>
                <label style="color:black">Total Projects Updated = <b>{{$lupcount}}</b></label><br>
                <label style="color:black">Total RMC Listed = <b>{{$lRMCCount}}</b></label><br>
                <label style="color:black">Total Blocks Listed = <b>{{$lBlocksCount}}</b></label>
                @else
                 <label style="color:black">Total Projects Added = <b>{{$tlcount}}</b></label><br>
                 <label style="color:black">Total Projects Updated = <b>{{$tlupcount}}</b></label>
                 @endif
                <table class="table table-striped" border="1">
                    <thead>
                        <th style="font-size: 10px;">Name</th>
                        <th style="font-size: 10px;">Sub Ward Name</th>
                        <th style="font-size: 10px;">Added</th>
                        <th style="font-size: 10px;">Updated</th>
                        <th style="font-size: 10px;">RMC</th>
                        <th style="font-size: 10px;">Blocks</th>
                        <th style="font-size: 10px;">Total</th>
                    </thead>
                  @if(Auth::user()->group_id != 22)
                    @foreach($users as $user)
                    <tr>
                        <td style="font-size: 10px;">{{ $user->name }}</td>
                        <td style="font-size: 10px;">{{ $user->sub_ward_name }}</td>
                        <td style="font-size: 10px;">{{ $totalListing[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalupdates[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalRMCListing[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalBlocksListing[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalListing[$user->id] + $totalupdates[$user->id] + $totalRMCListing[$user->id] + $totalBlocksListing[$user->id] }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th style="font-size: 10px;">Total</th>
                        <th style="font-size: 10px;"></th>
                        <th style="font-size: 10px;">{{ $lcount}}</th>
                        <th style="font-size: 10px;">{{ $lupcount}}</th>
                        <th style="font-size: 10px;">{{ $lRMCCount}}</th>
                        <th style="font-size: 10px;">{{ $lBlocksCount}}</th>
                        <th style="font-size: 10px;"></th>
                    </tr>
                    @else
                     @foreach($tlUsers as $user)
                    <tr>
                        <td style="font-size: 10px;">{{ $user->name }}</td>
                        <td style="font-size: 10px;">{{ $user->sub_ward_name }}</td>
                        <td style="font-size: 10px;">{{ $totalListing[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalupdates[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalRMCListing[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalBlocksListing[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalListing[$user->id] + $totalupdates[$user->id] + $totalRMCListing[$user->id] + $totalBlocksListing[$user->id] }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <th style="font-size: 10px;">Total</th>
                        <th style="font-size: 10px;"></th>
                        <th style="font-size: 10px;">{{$tlcount}}</th>
                        <th style="font-size: 10px;">{{ $tlupcount}}</th>
                        <th style="font-size: 10px;">{{ $tlRMCcount}}</th>
                        <th style="font-size: 10px;">{{ $tlBlocksCount}}</th>
                        <th style="font-size: 10px;"></th>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
        <div class="panel panel-default" style="border-color:green">
            <div class="panel-heading text-center" style="background-color:green">
                <b style="color:white">Mini Report of Account Executive(Today)</b>
            </div>
            <div class="panel-body" style="overflow-x:scroll;">
                @if(Auth::user()->group_id != 22)
              <label style="color:black">Total Projects Added = <b>{{$acount}}</b></label>
              <label style="color:black">Total Projects Updated = <b>{{$aupcount}}</b></label>
              <label style="color:black">Total RMC Listed = <b>{{ $aRMCcount }}</b></label><br>
              <label style="color:black">Total Blocks Listed = <b>{{ $aBlocksCount }}</b></label>
              @else
              <label style="color:black">Total Projects Added = <b>{{$tlacount}}</b></label><br>
              <label style="color:black">Total Projects Updated = <b>{{$tlupcount}}</b></label>
              <label style="color:black">Total RMC Listed = <b>{{ $tlAcRMCcount }}</b></label><br>
              <label style="color:black">Total Blocks Listed = <b>{{ $tlAcBlocksCount }}</b></label>
              @endif
                <table class="table table-striped" border="1">
                    <thead>
                        <th style="font-size: 10px;">Name</th>
                        <th style="font-size: 10px;">Sub Ward Name</th>
                        <th style="font-size: 10px;">Added</th>
                        <th style="font-size: 10px;">Updated</th>
                        <th style="font-size: 10px;">RMC</th>
                        <th style="font-size: 10px;">Blocks</th>
                        <th style="font-size: 10px;">Total</th>
                    </thead>
                @if(Auth::user()->group_id != 22)
                    @foreach($accusers as $user)
                    <tr>
                        <td style="font-size: 10px;">{{ $user->name }}</td>
                        <td style="font-size: 10px;">{{ $user->sub_ward_name }}</td>
                        <td style="font-size: 10px;">{{ $totalaccountlist[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalaccupdates[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalAccountRMCListing[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalAccountBlocksListing[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalaccupdates[$user->id]  +  $totalaccountlist[$user->id] + $totalAccountRMCListing[$user->id] + $totalAccountBlocksListing[$user->id] }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td style="font-size: 10px;">Total</td>
                        <td style="font-size: 10px;"></td>
                        <td style="font-size: 10px;">{{ $acount}}</td>
                        <td style="font-size: 10px;">{{ $aupcount}}</td>
                        <td style="font-size: 10px;">{{ $aRMCcount}}</td>
                        <td style="font-size: 10px;">{{ $aBlocksCount}}</td>
                        <td style="font-size: 10px;"></td>
                    </tr>
                    @else
                    @foreach($tlUsers1 as $user)
                    <tr>
                        <td style="font-size: 10px;">{{ $user->name }}</td>
                        <td style="font-size: 10px;">{{ $user->sub_ward_name }}</td>
                        <td style="font-size: 10px;">{{ $totalaccountlist[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalaccupdates[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalAccountRMCListing[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalAccountBlocksListing[$user->id] }}</td>
                        <td style="font-size: 10px;">{{ $totalaccupdates[$user->id]  +  $totalaccountlist[$user->id] + $totalAccountRMCListing[$user->id] + $totalAccountBlocksListing[$user->id] }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td style="font-size: 10px;">Total</td>
                        <td style="font-size: 10px;"></td>
                        <td style="font-size: 10px;">{{$tlacount}}</td>
                        <td style="font-size: 10px;">{{ $tlaupcount}}</td>
                        <td style="font-size: 10px;">{{ $tlAcRMCcount}}</td>
                        <td style="font-size: 10px;">{{ $tlAcBlocksCount}}</td>
                        <td style="font-size: 10px;"></td>
                    </tr>
                    @endif
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-9" >
        <div class="panel panel-primary" style="overflow-x:scroll">
            <div class="panel-heading" id="panelhead">
                <label>Daily Listings For The Date : <b>{{ date('d-m-Y',strtotime($date)) }}</b> &nbsp;&nbsp;&nbsp;&nbsp;Projects Added : <b>@if( $projcount  == 0)
                  No Projects Found
                @else
                  {{$projcount}}
                @endif
                </b></label>
                 <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color:black;"></i></button> 
            </div>
            <div class="panel-body">
                <table class='table table-responsive table-striped' style="color:black" border="1">
                    <thead>
                        <tr>
                            <th style="text-align:center">Subward Ward Name</th>
                            <th style="text-align:center">Project-ID</th>
                            <th style="text-align:center">Owner Contact Number</th>
                            <th style="text-align:center">Site Engineer Contact Number</th>
                            <th style="text-align:center">Procurement Contact Number</th>
                            <th style="text-align:center">Consultant Contact Number</th>
                            <th style="text-align:center">Contractor Contact Number</th>
                            <th style="text-align:center">Listing Engineer</th>
                            <!--<th style="text-align:center">Verification</th>-->
                        </tr>
                    </thead>
                    <tbody id="mainPanel">
                        <?php $users = []; ?>
                        @foreach($projects as $project)
                            @if($project->quality == "Fake")
                            <tr style='background-color:#d2d5db'>
                            @else
                                @if(!in_array($project->listing_engineer_id, $users))
                                <tr style='background-color:#91dd71'>
                                @else 
                                    <tr>
                                @endif
                            @endif
                            <?php array_push($users, $project->listing_engineer_id); ?>
                            <td style="text-align:center" >
                                <a href="{{ URL::to('/')}}/viewsubward?projectid={{$project->project_id}} && subward={{ $project->sub_ward_name }}" data-toggle="tooltip" data-placement="top" title="click here to view map" class="red-tooltip" target="_blank">{{ $project->subward != null ? $project->subward->sub_ward_name : '' }}
                             </a></td>
                            <td style="text-align:center"><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$project->project_id}}&&lename={{ $project->name }}" target="_blank">{{ $project->project_id }}</a></td>
                            <td style="text-align:center">{{$project->ownerdetails !=null ?$project->ownerdetails->owner_contact_no :''}}</td>
                            <td style="text-align:center">{{$project->siteengineerdetails != null?$project->siteengineerdetails->site_engineer_contact_no:''}}</td>
                            <td style="text-align:center">{{$project->procurementdetails !=null?$project->procurementdetails->procurement_contact_no :''}}</td>
                            <td style="text-align:center">{{$project->consultantdetails !=null ?$project->consultantdetails->consultant_contact_no :''}}</td>
                            <td style="text-align:center">{{$project->contractordetails !=null ?$project->contractordetails->contractor_contact_no:''}}</td>
                            <td style="text-align:center" id="listname-{{$project->project_id}}">
                                {{$project->user !=null ?$project->user->name:''}}
                                <input type="hidden" id="hiddeninp-{{$project->project_id}}" value="{{$project->listing_engineer_id}}" />
                            </td>
                            <!--<td style="text-align:center"><a onclick="" class="btn btn-sm btn-danger">Verify</a></td>-->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <center>
                    <div id="wait" style="display:none;width:200px;height:200px;"><img src='https://www.tradefinex.org/assets/images/icon/ajax-loader.gif' width="200" height="200" /></div>
                </center>
            </div>
        </div>
    </div>
    <script src="http://code.jquery.com/jquery-3.3.1.js"></script>
    <script type='text/javascript'>
        $( document ).ready(function() {
            var arr = new Array();
            var ids = new Array();
            for(var i=0; i<10000; i++)
            {
                if(document.getElementById('listname-'+i))
                {
                    arr[i] = document.getElementById('listname-'+i).innerText; //Pulling all names in arr array
                    ids[i] = document.getElementById('hiddeninp-'+i).value;
                }
            }
            var unique = arr.filter(function(item, i, ar){ return ar.indexOf(item) === i; }); //Filtering out unique names from arr array
            var uniqueids = ids.filter(function(item, i, ar){ return ar.indexOf(item) === i; }); //Filtering out unique IDs from ids array
            var ans = new Array();
            for(var i=0;i<unique.length;i++)
            {
                var x = unique[i];
                ans[x] = 0;
                for(var k=0;k<arr.length;k++)
                {
                    if(x == arr[k])
                    {
                        ans[x]++;
                    }
                }
            }


        });
    </script>
    <script>
$(document).ready(function(){
    $('[data-toggle="tooltip"]').tooltip();
     background-color: #00acd6 

});

</script>
@endsection
