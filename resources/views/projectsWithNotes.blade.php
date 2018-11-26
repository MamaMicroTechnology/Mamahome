@extends('layouts.app')
@section('content')
<div class="container">
<div class="col-md-12">
    <div class="panel panel-default" style="border-color:green;"> 
                <div class="panel-heading text-center" style="background-color: green;color:white;">Unverified Projects
                     <button type="button" onclick="history.back(-1)" class="bk-btn-triangle pull-right" style="margin-top:-10px;" > <i class="fa fa-arrow-circle-left" style="padding:5px;width:50px;color:black;"></i></button> 
                @if($totalproject != 0)
                    Count : <b>{{ $totalproject }}</b>
                @endif

                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                    <form method="GET" action="{{ URL::to('/') }}/projectWithNotes">
                        <div class="col-md-2">
                            <label>Choose Note :</label><br>
                            <select name="note" class="form-control">
                                <option value="">--Select--</option>
                                <option {{ isset($_GET['note']) ? $_GET['note'] == "WRONG NO" ? 'selected': '' : '' }} value="WRONG NO">WRONG NO</option>
                                <option {{ isset($_GET['note']) ? $_GET['note'] == "PROJECT CLOSED" ? 'selected': '' : '' }} value="PROJECT CLOSED">PROJECT CLOSED</option>
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Choose Ward :</label><br>
                            <select name="ward" class="form-control" id="ward" onchange="loadsubwards()" required>
                                <option value="">--Select--</option>
                                @foreach($wards as $ward)
                                <option {{ isset($_GET['ward']) ? $_GET['ward'] == $ward->id ? 'selected' : '' : '' }} value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label>Choose Subward :</label><br>
                            <select name="subward" class="form-control" id="subward" >
                            @if(isset($_GET['ward']))
                            <option value="">--Select--</option>
                            @foreach($subward as $sub)
                            <option {{ isset($_GET['subward']) ? $_GET['subward'] == $sub->id ? 'selected' : '' : '' }} value="{{ $sub->id }}">{{ $sub->sub_ward_name }}</option>
                            @endforeach
                            @endif
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label></label>
                            <input type="submit" value="Fetch" class="form-control btn btn-primary">
                        </div>
                    </form>
                </div>
            <br><br><br><br>
          <table class="table table-hover">
          <thead>
            <th>Project Id</th>
            <th>Project Name</th>
            
            <th>Project Status</th>
            <th>Quality</th>
            <th>Address</th>
            <th>Last Update</th>
            <th>Remarks</th>
          </thead>
          
          @foreach($projects as $project)
          <tbody>
            
            <td style="text-align:center"><a href="{{ URL::to('/') }}/admindailyslots?projectId={{$project->project_id}}&&lename={{ $project->name }}" target="_blank">{{ $project->project_id }}</a></td>
            <td>{{ $project->project_name }}</td>
            
            <td>{{ $project->project_status }}</td>
            <td>{{ $project->quality }}</td>
            <td>
            @foreach($site as $sites)
              @if($sites->project_id == $project->project_id)
              <a href="#" >{{ $sites->address }}</a>
              @endif
              @endforeach
            </td>
            <td style="width:10%;">
              {{ date('d-m-Y', strtotime($project->updated_at)) }}
              @foreach($names as $name)
                @if($name->id == $project->updated_by)
                 {{ $name->name}} 
                @endif
                @endforeach
            </td>
            <td>{{ $project->remarks }}</td>
          </tbody>
          @endforeach
          
        </table>
        @if(count($projects) != 0)
            {{ $projects->appends($_GET)->links() }}
        @endif
                </div>
             
               
    </div>
   </div>
</div>
<script type="text/javascript">
    function loadsubwards()
    {
        var x = document.getElementById('ward');
        var sel = x.options[x.selectedIndex].value;
        if(sel)
        {
            $.ajax({
                type: "GET",
                url: "{{URL::to('/')}}/loadsubwards",
                data: { ward_id: sel },
                async: false,
                success: function(response)
                {
                    if(response == 'No Sub Wards Found !!!')
                    {
                        document.getElementById('error').innerHTML = '<h4>No Sub Wards Found !!!</h4>';
                        document.getElementById('error').style,display = 'initial';
                    }
                    else
                    {
                        var html = "<option value='' disabled selected>---Select---</option>";
                        for(var i=0; i< response.length; i++)
                        {
                            html += "<option value='"+response[i].id+"'>"+response[i].sub_ward_name+"</option>";
                        }
                        document.getElementById('subward').innerHTML = html;
                    }
                    
                }
            });
        }
    }
</script>
@endsection
