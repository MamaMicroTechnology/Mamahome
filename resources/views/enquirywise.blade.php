@extends('layouts.leheader')
@section('content')
<div class="col-md-12" >
        <div class="panel panel-primary"  style="overflow-x:scroll">
           <div class="panel-heading text-center">
                    <a href="{{ URL::to('/') }}/inputview" class="btn btn-danger btn-sm pull-left">Add Enquiry</a>
                    <a class="pull-right btn btn-sm btn-danger" href="{{url()->previous()}}">Back</a>
                Enquiry Data&nbsp;&nbsp;&nbsp;   COUNT: [{{count($projects)}}]
            </div>
            <div class="panel-body">
                <table class='table table-responsive table-striped' style="color:black" border="1">
                    <thead>
                        <tr>
                            <th style="text-align:center">Project Id</th>
                            <th style="text-align:center">requirnment Date</th>
                            <th style="text-align:center"> Contact Number</th>
                            <th style="text-align:center">Quantity</th>
                            <th style="text-align:center">status</th>
                            <th style="text-align:center">Remark</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="mainPanel">
                       @foreach($projects as $project)
                       <tr>
                            <td style="text-align:center"><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$project->project_id}}&&lename={{ $project->name }}">{{ $project->project_id }}</a></td>
                            <td>{{ $project->requirement_date }}  </td> 
                            <td>{{ $project->procurement_contact_no      }}</td>
                            <td>{{ $project->quantity }}  </td>                     
                            <td>{{ $project->status }}  </td> 
                            <td>{{ $project->notes }} </td>
                            
                            <td><a href="{{ URL::to('/') }}/editenq?reqId={{ $project->id }}" class="btn btn-xs btn-primary">Edit</a></td>

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
@endsection
