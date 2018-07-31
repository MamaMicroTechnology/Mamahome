@extends('layouts.app')
@section('content')

<div class="container">
    <div class="row">
        <div class="panel panel-primary">
            <div class="panel-heading text-center" ><b>Follow Up Projects</b></div>
            <div class ="panel-body">
                <form method="GET" action="{{ URL::to('/') }}/followup_project">
                        <div class="col-md-12">
                                    <div class="col-md-2">
                                        <label>From (Follow_Up  Date)</label>
                                        <input value = "{{ isset($_GET['from']) ? $_GET['from']: '' }}" type="date" class="form-control" name="from">
                                    </div>
                                    <div class="col-md-2">
                                        <label>To (Follow_Up Date)</label>
                                        <input  value = "{{ isset($_GET['to']) ? $_GET['to']: '' }}" type="date" class="form-control" name="to">
                                    </div>
                                    <div class="col-md-2">
                                    <label></label>
                                    <input type="submit" value="Fetch" class="form-control btn btn-primary">
                                </div>
                        </div>
                </form>
                <br><br><br><hr>
                                <table class="table table-responsive" border=1>
                                    <thead>
                                        <th>Sl No</th>
                                        <th>Follow Up Date</th>
                                        <th>Project Name</th>
                                        <th>Owner Contact</th>
                                        <th>Procurement Contact</th>
                                        <th>Consultant Contact</th>
                                        <th>Site Engineer Contact</th>
                                        <th>Contractor Contact</th>
                                        <!-- <th>Update Follow Up</th> -->
                                        <th>Enquiry</th>
                                    </thead>
                                    <tbody>
                                        @foreach($projects as $project)
                                        <tr>
                                            <td>{{$project->project_id}}</td>
                                            <td>{{ date('d-m-Y', strtotime($project->followup)) }}</td>
                                            <td>{{ $project->project_name }}</td>
                                            <td>{{ $project->owner_contact_no}}</td>
                                            <td>{{ $project->procurement_contact_no}}</td>
                                            <td>{{ $project->consultant_contact_no}}</td>
                                            <td>{{ $project->site_engineer_contact_no}}</td>
                                            <td>{{ $project->contractor_contact_no}}</td>
                                            <td>{{ $project->main_category }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
            </div>
         
        </div>
    </div>
</div>
<!-- <script type="text/javascript">
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
</script> -->
@endsection