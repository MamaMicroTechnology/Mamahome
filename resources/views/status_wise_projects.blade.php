@extends('layouts.app')

@section('content')
<div class="col-md-10" >
        <div class="panel panel-primary"  style="overflow-x:scroll">
            <div class="panel-heading" id="panelhead" style="background-color: rgb(244, 129, 31);">

               <h2>Project Details Of 
               {{ $status }} Stage
                   <div class="pull-right">{{ count($projects) }} Projects Found</div>
               </h2> 
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
                            <th style="text-align:center">Add Enquiry</th> 
                             <th style="text-align:center">Action</th> 
                             <th style="text-align: center">Blocked </th>
                            <!--<th style="text-align:center">Verification</th>-->
                        </tr>
                    </thead>
                    <tbody id="mainPanel">
                        @foreach($projects as $project)
                        @if($project->deleted=='0')
                        <tr>
                            <td style="text-align:center">{{ $project->sub_ward_name }}</td>
                            <td style="text-align:center"><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$project->project_id}}&&lename={{ $project->name }}">{{ $project->project_id }}</a></td>
                            
                            <td style="text-align:center">{{$project->owner_contact_no}}</td>
                            <td style="text-align:center">{{$project->site_engineer_contact_no}}</td>
                            <td style="text-align:center">{{$project->procurement_contact_no}}</td>
                            <td style="text-align:center">{{$project->consultant_contact_no}}</td>
                            <td style="text-align:center">{{$project->contractor_contact_no}}</td>
                            <td> <a class="btn btn-sm btn-primary " name="addenquiry" onclick="addrequirement()" style="color:white;font-weight:bold;background-color: green">Add Enquiry</a></td>
                           <td> <form method="post" action="{{ URL::to('/') }}/confirmedProject">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $project->project_id }}" name="id">
                                        <div class="checkbox">
                                          <label><input type="checkbox" {{ $project->confirmed == "True"?'checked':'' }} name="confirmed" onchange="this.form.submit()">Called</label>
                                        </div>

                                     
                                      </div>
                                

                                         
                             </form></td>
                            <td>
                               <div class="btn-group btn-group-xs">
                                   <form action="{{ url('/toggle-approve')}}" method="post">
                                 {{csrf_field()}}
                                  <input value="off" type="hidden" name="deleted">
                                  <input type="hidden" name="id" value="{{$project->project_id}}">
                                  <button type="submit" data-toggle="tooltip"onclick="return confirm('Are you sure you want to Block this Project?');"  button class="btn btn-sm" style="background-color:#F57F1B;color:white;font-weight:bold">Block
                               </button>
                              </form>
                            </div>
                            </td> 
                           
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                <center>
                        {{$projects->links()}}
                </center>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        function addrequirement(){
            var id = document.getElementsByName('addenquiry').id;
            window.location.href="{{ URL::to('/') }}/requirements?projectId="+id;
        }
    </script>


@endsection