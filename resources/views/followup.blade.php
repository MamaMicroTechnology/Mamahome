@extends('layouts.sales')
@section('content')

<div class="container">
    <div class="row">
        <div class="panel panel-warning">
            <div class="panel-heading text-center"><b>Follow Up Projects</b></div>
            <div class ="panel-body">
                <table class="table table-responsive" border=1>
                    <thead>
                        <th>Sl No</th>
                        <th>Required Date</th>
                        <th>Project Name</th>
                        <th>Owner contact</th>
                        <th>Procurement contact</th>
                        <th>Consultant Contact</th>
                        <th>Site Engineer Contact</th>
                        <th>Contractor Contact</th>
                        <th>Update Follow Up</th>
                        <th>Enquiry</th>
                    </thead>
                    <tbody>
                        @foreach($projects as $project)
                        <tr>
                            <td>{{$project->project_id}}</td>
                            <td>{{ $project->reqDate }}</td>
                            <td>{{ $project->project_name }}</td>
                            <td>{{ $project->ownerdetails != NULL ? $project->ownerdetails->owner_contact_no:'' }}</td>
                            <td>{{ $project->procurementdetails != NULL ? $project->procurementdetails->procurement_contact_no:'' }}</td>
                            <td>{{ $project->consultantdetails != NULL ? $project->consultantdetails->consultant_contact_no:'' }}</td>
                            <td>{{ $project->siteengineerdetails != NULL ? $project->siteengineerdetails->site_engineer_contact_no:'' }}</td>
                            <td>{{ $project->contractordetails != NULL ? $project->contractordetails->contractor_contact_no: '' }}</td>
                            <td><input tabindex="-1" value="{{ $project->note }}" id="note-{{$project->project_id}}" name="note-{{$project->project_id}}" class="form-control" onblur="updatenote({{$project->project_id}})" /></td>
                            <td>{{ $project->remarks }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
		<div class="panel-footer">
			<center>{{ $projects->links() }}</center>
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
@endsection
