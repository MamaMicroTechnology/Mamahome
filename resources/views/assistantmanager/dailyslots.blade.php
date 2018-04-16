@extends('layouts.amheader')
@section('content')
    <div class="col-md-2">
        <div class="panel panel-primary" style="overflow-x:scroll">
            <div class="panel-heading text-center">
                <b style="color:white">Custom Daily Slot</b>
            </div>
            <div class="panel-body">
                <table class="table table-responsive">
                    <tbody >
                        <tr>
                            <td>Select Listing Engineer</td>
                        </tr>
                        <tr>
                            <td>
                                <select class="form-control" id="selectle">
                                    <option disabled selected value="">(-- SELECT LE --)</option>
                                    <option value="ALL">All Listing Engineers</option>
                                    @foreach($le as $list)
                                    <option value="{{$list->id}}">{{$list->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>Select From Date</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="date" placeholder= "From Date" class="form-control" id="fromdate" name="fromdate" />
                            </td>
                        </tr>
                        <tr>
                            <td>Select To Date</td>
                        </tr>
                        <tr>
                            <td>
                                <input type="date"  placeholder= "To Date" class="form-control" id="todate" name="todate" />
                            </td>
                        </tr>
                        <tr class="text-center">
                            <td>
                                <a class="btn bn-md btn-success" style="width:100%" onclick="showrecordsle()">Get Date Range Details</a>
                            </td>
                        </tr>
                        <!--<tr class="text-center">-->
                        <!--    <td>-->
                        <!--        <a class="btn bn-md btn-primary" style="width:100%" onclick="showtodayrecordsle()">Get Date Details</a>-->
                        <!--    </td>-->
                        <!--</tr>-->
                    </tbody>
                </table>
            </div>
        </div>
        <div class="panel panel-default" styke="border-color:green">
            <div class="panel-heading text-center" style="background-color:green">
                <b style="color:white">Mini Report (Today)</b>
            </div>
            <div class="panel-body">
                <label style="color:black">Total Count : <b>{{$projcount}}</b></label>
                <table class="table table-striped" border="1">
                    @foreach($users as $user)
                    <tr>
                        <td style="font-size: 10px;">{{ $user->name }}</td>
                        <td style="font-size: 10px;">{{ $user->sub_ward_name }}</td>
                        <td style="font-size: 10px;">{{ $totalListing[$user->id] }}</td>
                    </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
    <div class="col-md-10" >
        <div class="panel panel-primary" style="overflow-x:scroll">
            <div class="panel-heading" id="panelhead">
                <label>Daily Listings For The Date : <b>{{ date('d-m-Y', strtotime($date)) }}</b> &nbsp;&nbsp;&nbsp;&nbsp;Current Count: <b>{{$projcount}}</b></label>
                <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>
            </div>
            <div class="panel-body">
                <table class='table table-responsive table-striped' style="color:black" border="1">
                    <thead>
                        <tr>
                            <th style="text-align:center">Ward No.</th>
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
                        @foreach($projects as $project)
                        <tr>
                            <td style="text-align:center">{{ $project->sub_ward_name }}</td>
                            <td style="text-align:center"><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$project->project_id}}&&lename={{ $project->name }}">{{ $project->project_id }}</a></td>
                            <td style="text-align:center">{{$project->owner_contact_no}}</td>
                            <td style="text-align:center">{{$project->site_engineer_contact_no}}</td>
                            <td style="text-align:center">{{$project->procurement_contact_no}}</td>
                            <td style="text-align:center">{{$project->consultant_contact_no}}</td>
                            <td style="text-align:center">{{$project->contractor_contact_no}}</td>
                            <td style="text-align:center" id="listname-{{$project->project_id}}">
                                {{$project->name}}
                                <input type="hidden" id="hiddeninp-{{$project->project_id}}" value="{{$project->listing_engineer_id}}" />
                            </td>
                            <!--<td style="text-align:center"><a onclick="" class="btn btn-sm btn-danger">Verify</a></td>-->
                        </tr>
                        @endforeach
                    </tbody>
                </table>
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
            for (var k in ans){
                if (ans.hasOwnProperty(k)) {
                     document.getElementById('minireport').innerHTML += "<br><label style='color:black'>"+ k + " : "+ans[k];
                     //alert("Key is " + k + ", value is" + ans[k]);
                }
            }
            
        });
        function showrecordsle()
        {
            var e = document.getElementById("selectle");
            var le_id = e.options[e.selectedIndex].value;
            var from_date = document.getElementById('fromdate').value;
            var to_date = document.getElementById('todate').value;
            if(to_date==""){
                showtodayrecordsle();
            }else if(!le_id || !from_date){
                alert('Incomplete Details ! Please Select All Three Fields !!');
                return false;
            }
            else
            {
                var mydate = new Date(from_date);
                var todate = new Date(to_date);
                var month = mydate .getMonth() + 1;
                var day = mydate .getDate();
                var year = mydate .getFullYear();
                var tomonth = todate .getMonth() + 1;
                var today = todate .getDate();
                var toyear = todate .getFullYear();
                if(day < 10){
                    day = "0" + day;
                }
                if(month < 10){
                    month = "0" + month;
                }
                if(today < 10){
                    today = "0" + today;
                }
                if(tomonth < 10){
                    tomonth = "0" + tomonth;
                }
                orig_from_date = day + "-" + month + "-" + year;
                orig_to_date = today + "-" + tomonth + "-" + toyear;
                from_date += ' 00:00:00';
                to_date += ' 00:00:00';
                document.getElementById('mainPanel').innerHTML = '';
                document.getElementById('panelhead').innerHTML = '';
                $.ajax({
                    type: 'GET',
                    url: "{{ URL::to('/') }}/getleinfo",
                    data: { id: le_id, from: from_date, to: to_date },
                    async: false,
                    success: function(response)
                    {
                        document.getElementById('panelhead').innerHTML = "<label style='font-weight:bold;'>Listings From Date : <b> "+orig_from_date+" </b> To "+orig_to_date+"  &nbsp;&nbsp;&nbsp;&nbsp; Total Count: <b>"+response[1]+"</b></label>";
                        
                        document.getElementById('mainPanel').innerHTML = '';
                        for(var i=0; i<response[0].length;i++)
                        {
                            document.getElementById('mainPanel').innerHTML += 
                            "<tr><td>"
                                +response[0][i].sub_ward_name+
                            "</td><td><a href='{{URL::to('/')}}/admindailyslots?projectId="+response[0][i].project_id+"&&lename="+response[0][i].name+"'>"
                                +response[0][i].project_id+
                            "</a></td><td>"
                                +response[0][i].owner_contact_no+
                            "</td><td>"
                                +response[0][i].site_engineer_contact_no+
                            "</td><td>"
                                +response[0][i].procurement_contact_no+
                            "</td><td>"
                                +response[0][i].consultant_contact_no+
                            "</td><td>"
                                +response[0][i].contractor_contact_no+
                            "</td><td><a href='{{URL::to('/')}}/dailyslots?userId="+response[0][i].id+"'>"
                                +response[0][i].name+
                            "</a></td></tr>";
                        }
                        console.log(response);   
                    }    
                });
            }
            return false;
        }
        function showtodayrecordsle()
        {
            var e = document.getElementById("selectle");
            var le_id = e.options[e.selectedIndex].value;
            var from_date = document.getElementById('fromdate').value;
            if(!le_id || !from_date){
                alert('Please Select A Listing Engineer And From Date !!');
                return false;
            }
            else
            {
                var mydate = new Date(from_date);
                var month = mydate .getMonth() + 1;
                var day = mydate .getDate();
                var year = mydate .getFullYear();
                if(day < 10){
                    day = "0" + day;
                }
                if(month < 10){
                    month = "0" + month;
                }
                orig_from_date = day + "-" + month + "-" + year;
        
                document.getElementById('mainPanel').innerHTML = '';
                document.getElementById('panelhead').innerHTML = '';
                $.ajax({
                    type: 'GET',
                    url: "{{ URL::to('/') }}/gettodayleinfo",
                    data: { id: le_id, from_date: from_date },
                    async: false,
                    success: function(response)
                    {
                        document.getElementById('panelhead').innerHTML = "<label style='font-weight:bold;'>Listings From Date : <b> "+orig_from_date+" </b>  &nbsp;&nbsp;&nbsp;&nbsp; Total Count: <b>"+response[1]+"</b></label>";
                        
                        document.getElementById('mainPanel').innerHTML = '';
                        for(var i=0; i<response[0].length;i++)
                        {
                            document.getElementById('mainPanel').innerHTML += 
                            "<tr><td>"
                                +response[0][i].sub_ward_name+
                            "</td><td><a href='{{URL::to('/')}}/admindailyslots?projectId="+response[0][i].project_id+"&&lename="+response[0][i].name+"'>"
                                +response[0][i].project_id+
                            "</a></td><td>"
                                +response[0][i].owner_contact_no+
                            "</td><td>"
                                +response[0][i].site_engineer_contact_no+
                            "</td><td>"
                                +response[0][i].procurement_contact_no+
                            "</td><td>"
                                +response[0][i].consultant_contact_no+
                            "</td><td>"
                                +response[0][i].contractor_contact_no+
                            "</td><td><a href='{{URL::to('/')}}/dailyslots?userId="+response[0][i].id+"'>"
                                +response[0][i].name+
                            "</a></td></tr>";
                        }
                        console.log(response);   
                    }    
                });
            }
            return false;
        }
    </script>

@endsection