<?php
    if(Auth::user()->department_id == 0){
        $exts = "layouts.app";
    }else{
        $exts = "layouts.amheader";
    }
?>
@extends($exts)

@section('content')
<div class="container">
<div class="col-md-6">
    <div class="panel panel-default" style="border-color:green;">

               
                <div class="panel-heading" style="background-color: green;color:white;"><b> View Training Videos</b> <br> Please select the Department and designation in order to get the training videos


                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                </div>
                <div class="panel-body">
            <form method="GET" action="{{ URL::to('/') }}/video">
                            <table class="table">
                                <tr>
                                    <td>Department</td>
                                    <td>Designation</td>
                                    
                                </tr> 
                                <tr>
                                    <td><select required class="form-control" name="dept">
                                    <option value="">--Select--</option>
                                        @foreach($depts as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->dept_name }}
                                    </option>
                                         @endforeach
                                         </select>
                                    </td>
                                    <td>
                                    <select required class="form-control" name="designation">
                                    <option value="">--Select--</option>
                                     @foreach($grps as $grp)
                                   <option value="{{ $grp->id }}">{{ $grp->group_name }}</option>
                                  @endforeach
                                     </select>
                                    </td>
                                    <td>
                                     <input type="submit" class="btn btn-success" value="Submit">
                                     </td>

                                </tr>
                            
                        </table>
                    </form>
                    <table class="table table-responsive">
                        <tr>
                                    <td>Video Title </td>
                                    <td >Action</td>

                        </tr>
                        @if($videos != "none")
                        @foreach($videos as $video)

                        <tr>
                            <td>{{ $video->remark }}</td>
                            <td>
                                <button data-toggle="modal" data-target="#myModal{{ $video->id }}" class="btn btn-sm btn-primary">View</button>
                           
                                <!-- <a href="{{ URL::to('/')}}/deleteentry?id={{ $video->id }}" class="btn btn-sm btn-danger" >Delete</a> -->
                               
                            </td>
                        </tr>
                   
                            <div id="myModal{{ $video->id }}" class="modal fade" role="dialog">
                              <div class="modal-dialog">

                                <!-- Modal content-->
                                <div class="modal-content">
                                  <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                                    <h4 class="modal-title">{{ $video->remark }}</h4>
                                  </div>
                                  <div class="modal-body">
                                    <video class="img img-responsive" controls>
                                      <source src="{{ URL::to('/') }}/public/trainingvideo/{{ $video->upload }}" type="video/mp4">
                                      <source src="{{ URL::to('/') }}/public/trainingvideo/{{ $video->upload }}" type="video/ogg">
                                      
                                    </video>
                                  </div>
                                  <div class="modal-footer">
                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                  </div>
                                </div>

                              </div>
                        </div>
                    @endforeach
                    @endif
                </table>    
            </div>
        </div>
     </div>

<div class="col-md-6">
            <div class="panel panel-default" style="border-color:green">
                <div class="panel-heading" style="background-color: green;color:white;"><b>Upload Training Videos</b>
                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                </div>
                <div class="panel-body">
            <form method="POST" action="{{ URL::to('/') }}/uploadvideo" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <table class="table">
                                <tr>
                                    <td>Department</td>
                                    <td>Designation</td>
                                    <td>Upload video(only mp4 format)</td>
                                </tr>
                                <tr>
                                    <td><select required class="form-control" name="dept">
                                    <option value="">--Select--</option>
                                        @foreach($depts as $dept)
                                    <option value="{{ $dept->id }}">{{ $dept->dept_name }}</option>
                                         @endforeach
                                         </select>
                                    </td>
                                    <td>
                                    <select required class="form-control" name="designation">
                                    <option value="">--Select--</option>
                                     @foreach($grps as $grp)
                                   <option value="{{ $grp->id }}">{{ $grp->group_name }}</option>
                                  @endforeach
                                     </select>
                                </td>

                                    <td><input type="file" name="upload" required class="form-control input-sm" accept="video/*">
                                    </td>
                                    
                                    
                                </tr>
                                <tr>
                                <tr>
                                    <td>
                                    Video Title
                                    </td>
                                </tr>
                                    <td>
                                        <input type="text" name="remark" class="form-control"  placeholder="Title">
                                    </td>
                                
                                    <td ><button type="submit" class="btn btn-success pull-right ">Save</button></td>
                                </tr>
                            </table>
                             
                        </form>                                                   
            	</div>
			</div>
        </div>
</div>
<div class="container">
<div class="col-md-6"></div>
<div class="col-md-6">
            <div class="panel panel-default" style="border-color:green;">
                <div class="panel-heading" style="background-color: green;color:white;"><b>Available Videos</b>
                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                </div>
                <div class="panel-body" style="height: 500px;max-height: 500pxoverflow-y: scroll;overflow-x: scroll;">
                    <table class="table table-responsive">
                        <tr>
                                    <td><b>Video Title</b></td>
                                    

                        </tr>
                       
                        @foreach($titles as $title)
                        <tr>
                            <td>{{ $title->remark }}</td>
                            
                        </tr>
                        @endforeach 
                       
                    </table>
                </div>
            </div>
</div>
</div>

