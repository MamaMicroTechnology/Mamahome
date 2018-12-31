<?php
    $user = Auth::user()->group_id;
    $ext = ($user == 1? "layouts.teamheader":"layouts.app");
?>
@extends($ext)
@section('content')
<div class="container">
<div class="col-md-12">
    <div class="panel panel-default" style="border-color:green;"> 
                <div class="panel-heading text-center" style="background-color: green;color:white;">Unverified Projects
                @if($totalproject != 0)
               Count : <b>{{ $totalproject }}</b>
                @endif

                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                </div>
                <div class="panel-body">
                    <div class="col-md-12">
                    <form method="GET" action="{{ URL::to('/') }}/unverifiedProjects">
                        <div class="col-md-2">
                <label>Choose Ward :</label><br>
                          <select required name="ward" class="form-control" id="ward" onchange="loadsubwards()">
                              <option value="">--Select--</option>
                              @if(Auth::user()->group_id != 22)
                              <option value="All">All</option>
                              @foreach($wards as $ward)
                              <option value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
                              @endforeach
                              @else
                              @foreach($tlwards as $ward)
                              <option value="{{ $ward->id }}">{{ $ward->ward_name }}</option>
                              @endforeach
                              @endif
                              

                          </select>
              </div>
              <div class="col-md-2">
                <label>Choose Subward :</label><br>
                          <select name="subward" class="form-control" id="subward">
                          </select>
              </div>
              <div class="col-md-2">
                <label></label>
                <input type="submit" value="Fetch" class="form-control btn btn-primary">
              </div>

                  <!-- Modal -->
                  <div class="modal fade" id="myModal" role="dialog">
                    <div class="modal-dialog">
                    
                      <!-- Modal content-->
                      <div class="modal-content">
                        <div class="modal-header" style="background-color: #478229;color: white;">
                          <button type="button" class="close" data-dismiss="modal">&times;</button>
                          <h4 class="modal-title">Project Status</h4>
                        </div>
                        <div class="modal-body">
                          

                             <div class="col-sm-12">
                                    <div class="col-md-3" >
                                            <label class="checkbox-inline">
                                              <input style="width: 33px;" id="planning" type="checkbox"  name="status[]" value="Planning"><span>&nbsp;&nbsp;&nbsp;</span>Planning
                                            </label>
                                          
                                             <label class="checkbox-inline">
                                              <input id="digging" type="checkbox"  name="status[]" value="Digging">Digging
                                            </label>
                                          
                                             <label class="checkbox-inline">
                                              <input id="foundation" type="checkbox"  name="status[]" value="Foundation">Foundation
                                            </label>
                                         
                                             <label class="checkbox-inline">
                                              <input id="pillars" type="checkbox"  name="status[]" value="Pillars">Pillars
                                            </label>

                                            <label class="checkbox-inline">
                                            <input id="walls" type="checkbox"  name="status[]" value="Walls">Walls
                                          </label>
                                          </div>
                                         <div class="col-md-3">
                                          
                                          <label class="checkbox-inline">
                                          <input id="roofing" style="width: 33px;" type="checkbox"  name="status[]" value="Roofing"><span>&nbsp;&nbsp;&nbsp;</span>Roofing
                                        </label>
                                       
                                          <label class="checkbox-inline">
                                          <input id="electrical" type="checkbox"  name="status[]" value="Electrical">Electrical
                                        </label>
                                       
                                          <label class="checkbox-inline">
                                          <input id="plumbing" type="checkbox"  name="status[]" value="Plumbing">Plumbing
                                        </label>

                                        <label class="checkbox-inline">
                                          <input id="plastering" type="checkbox"  name="status[]" value="Plastering">Plastering
                                        </label>
                                       
                                          <label class="checkbox-inline">
                                          <input id="flooring" type="checkbox"  name="status[]" value="Flooring">Flooring
                                        </label>

                                      </div>
                                       <div class="col-md-3">
                                        
                                          <label class="checkbox-inline">
                                          <input id="carpentry" style="width: 33px;" type="checkbox"  name="status[]" value="Carpentry"><span>&nbsp;&nbsp;&nbsp;</span>Carpentry
                                        </label>
                                       
                                          <label class="checkbox-inline">
                                          <input id="paintings" type="checkbox"  name="status[]" value="Paintings">Paintings
                                        </label>

                                        <label class="checkbox-inline">
                                          <input id="fixtures" type="checkbox"  name="status[]" value="Fixtures">Fixtures
                                        </label>
                                      
                                          <label class="checkbox-inline">
                                          <input id="completion" type="checkbox"  name="status[]" value="Completion">Completion
                                        </label>
                                        
                                          <label class="checkbox-inline">
                                          <input id="closed" type="checkbox"  name="status[]" value="Closed">Closed
                                        </label>
                                       </div>
                                 </div>
                             

                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Save</button>
                        </div>
                      </div>
                      
                    </div>
                  </div>
                  <!-- modal end -->
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
