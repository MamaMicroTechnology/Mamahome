
@extends('layouts.app')
@section('content')
<br>
<div class="col-md-8 col-md-offset-2">
<div class="panel panel-success">
    <div class="panel-heading">
      Total Customers <center  style="font-weight:bold;">{{$count}} </center>
    </div>
    <div class="panel-body">
        <div class="col-md-6 col-md-offset-6">
            <center>Fetch The Customers Depends On Projects And Manufactureres </center>
            <form method="GET" action="{{ URL::to('/') }}/details">
                <select required class="form-control" name="type">
                    <option value="">--Select--</option>
                    <option value="manu">Manufacturer</option>
                    <option value="project">Projects</option>
                    
                </select><br>
                <button class="btn btn-primary form-control" type="submit">Fetch</button>
            </form>
            <br>
        </div>
        @if($count > 0)
         <form method="POST" id="saveNumber" name="myform" action="{{ URL::to('/') }}/storeproject" enctype="multipart/form-data">
                {{ csrf_field() }}   
        <h4>  List Of Team Members</h4>
       <select name="user_id" onchange="this.form.submit()" class="form-control" style="width: 30%;">
                          <option value="">--Select--</option>
                          
                          @foreach($users as $user)  
                            <option value="{{ $user->id }}">{{$user->name}}</option>
                           @endforeach
                            </select>
         @endif                  
        <table class="table table-hover table-striped">
                <thead>
                  <th> Id</th>
                  <th>Customers Name</th>
                  <th>Customers Number</th>
              </thead>
              <tbody>
                 <?php $i = 0; ?>
                      <?php
                          $projectids =[];
                       ?>
                @foreach($project as $projects )


                        <?php
                            $i++;
                            if(count($projects->project_id) != 0){

                            $temp = $projects->project_id;
                            }else{
                            $temp = $projects->id;

                            }


                            array_push($projectids, $temp);
                           
                          
                          ?>
                           @if(count($projects->project_id) != 0)
                          <input type="hidden" name="type" value="project">
                          @else
                            <input type="hidden" name="type" value="Manufacturer">
                            @endif
                     <tr>
                    <td><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$projects->project_id}}&&lename={{ $projects->name }}" target="_blank">{{ $projects->project_id }}</a> <a href="{{ URL::to('/') }}/viewmanu?id={{ $projects->id }}"> {{$projects->id}}</a></td>
               
                    
                     <td>{{ $projects->procurementdetails != NULL?$projects->procurementdetails->procurement_name:'' }} {{$projects->proc != null ? $projects->proc->name : $projects->name  }}</td>
                   
        
                    <td>{{$projects->proc != null ? $projects->proc->contact : $projects->contact_no  }}{{ $projects->procurementdetails != NULL?$projects->procurementdetails->procurement_contact_no:'' }}</td> 
                 </tr>   
                 @endforeach  
                  <?php
                            $numb = implode(", ", $projectids);

                   ?>
                    <input type="hidden" name="num" value="{{ $numb }}">
                 </tbody>
                 </table>
         </form> 
                 @if($count > 0)
<center>{{ $project->appends(request()->query())->links()}} </center>
@endif
    </div>
</div>
</div>
 @if(session('success'))
          <script>
            swal("Success","{{ session('success')}}","success");
          </script>
 @endif
 @if(session('NotAdded'))
          <script>
            swal("Error","{{ session('NotAdded')}}","error");
          </script>
  @endif
@endsection
