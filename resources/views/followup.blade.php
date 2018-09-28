@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading text-center"><b>Follow Up Projects</b></div>
            <div class ="panel-body">
                 <!-- <form method="GET" action="{{ URL::to('/') }}/followupproject">
                        <div class="col-md-12">
                                    <div class="col-md-2">
                                        <label>From (Follow_up  Date)</label>
                                        <input value = "{{ isset($_GET['from']) ? $_GET['from']: '' }}" type="date" class="form-control" name="from">
                                    </div>
                                    <div class="col-md-2">
                                        <label>To (Follow_up Date)</label>
                                        <input  value = "{{ isset($_GET['to']) ? $_GET['to']: '' }}" type="date" class="form-control" name="to">
                                    </div>
                                    <div class="col-md-2">
                                    <label></label>
                                    <input type="submit" value="Fetch" class="form-control btn btn-primary">
                                </div>
                        </div>
                </form> -->
                <!-- <br><br><br><hr> -->
                <table class="table table-responsive" border=1>
                    <thead>
                        <th>Project-Id</th>
                        <th>Project Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Required Date</th>
                        <th>Follow Up Date</th>
                        <th>Update Follow Up</th>
                        <th>Enquiry</th>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td  style="text-align:center"><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$project->project_id}}&&lename={{ $project->name }}" target="_blank">{{ $project->project_id }}</a></td>
                            <td>{{ $project->project_name }}</td>
                             <td id="projsite-{{$project->project_id}}">
                                     <a target="_blank" href="https://maps.google.co.in?q={{ $project->siteaddress != null ? $project->siteaddress->address : '' }}">{{ $project->siteaddress != null ? $project->siteaddress->address : '' }}</a>
                                    </td>
                            <td>{{ $project->procurementdetails != NULL ? $project->procurementdetails->procurement_contact_no:'' }}</td>
                            <td>{{$project->reqDate ? date('d-m-Y', strtotime($project->reqDate)) : " "}}</td>
                            <td>{{$project->follow_up_date ? date('d-m-Y', strtotime($project->follow_up_date)) : " " }}</td>
                            <td><input tabindex="-1" value="{{ $project->note }}" id="note-{{$project->project_id}}" name="note-{{$project->project_id}}" class="form-control" onblur="updatenote({{$project->project_id}})" /></td>
                            <td><a class="btn btn-sm btn-success" id="addenquiry" onclick="addrequirement({{$project->project_id}})" style="color:white;font-weight:bold">Add Enquiry</a></td>
                        </tr> 
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function updatenote(arg)
    {
        if(document.getElementById('note-'+arg).value)
        {
            var x = document.getElementById('note-'+arg).value;
            $.ajax({
                type: 'GET',
                url: "{{URL::to('/')}}/updateNoteFollowUp",
                async:false,
                data: {value: x, id: arg},
                success: function(response)
                {
                    console.log(response);
                }
            });
            
        }    
        return false;
    }
</script>
<script type="text/javascript">
        function addrequirement(id){
            window.location.href="{{ URL::to('/') }}/requirements?projectId="+id;
        }
    </script>
@endsection