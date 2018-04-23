<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 7? "layouts.sales":"layouts.app");
?>
@extends($ext)
@section('content')
	
           
<div class="col-md-12">
        <div class="col-md-6">
          <div class="panel panel-default" style="overflow: scroll;">
            <div class="panel-heading" style="background-color:#158942;color:white;font-size:1.4em;font-weight:bold">Blocked Project List </div>  
            <div class="panel-body">
              <table class="table table-hover table-striped">
                <thead>
                  <th>Project Name</th>
                  <th>Project Id</th>
                  <th>Procurement Name</th>
                  <th>Contact No.</th>
                  <th>Action</th>
                </thead>

                  @foreach($projects as $project)
                              @if($project->deleted=='2')
                  <tr>
                    <td id="projname-{{$project->project_id}}">{{ $project->project_name }}</td>
                    <td style="text-align:center">{{ $project->project_id }}</td>
                    
                    <td id="projproc-{{$project->project_id}}">
                                        {{ $project->procurementdetails != NULL?$project->procurementdetails->procurement_name:'' }}
                                    </td>
                    <td id="projcont-{{$project->project_id}}"><address>{{ $project->procurementdetails != NULL?$project->procurementdetails->procurement_contact_no:'' }}</address></td>

                    <td>
                    <div class="btn-group btn-group-xs">
                                   <form action="{{ url('/toggle-approve1')}}" method="post">
                                 {{csrf_field()}}
                                  <input value="off" type="hidden" name="deleted">
                                  <input type="hidden" name="id1" value="{{$project->project_id}}">
                                  <button type="submit" data-toggle="tooltip"onclick="return confirm('Are you sure you want to Block this Project?');"  button class="btn btn-sm" style="background-color:#F57F1B;color:white;font-weight:bold">UnBlock
                               </button>
                              </form>
                            </div>
                    </td>
                  </tr>
                                 @endif
                  @endforeach
                </tbody>
              </table>
                </table>
                </div>
                </div>
                </div>
                </div>






 @endsection