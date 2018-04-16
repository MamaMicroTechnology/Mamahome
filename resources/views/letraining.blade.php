@extends('layouts.sales')
@section('content')

<div class="">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="panel panel-default" style="border-color:green">
			 <div class="panel-heading" style="background-color: green;color:white;"><b>Training video</b>
                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                </div>
			<div class="panel-body">
				<form method="GET" action="{{ URL::to('/') }}/letraining">
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
                                		@foreach($video as $video)
								@if($video->dept == "1" && $video->designation == "6")
									<center style="color:green;font-size: 20px">{{$video->remark}}</center>
								</br></br>

							
							<video class="img img-responsive" controls>
                                      <source src="{{ URL::to('/') }}/trainingvideo/{{ $video->upload }}" type="video/mp4">
                                      <source src="{{ URL::to('/') }}/trainingvideo/{{ $video->upload }}" type="video/ogg">
                              
                             </video><br>
                              @endif
                              @endforeach
                          </tr>
                    
                               </table>
                          </div>
                     </div>
                  </div>
              </div>

                                
						
@endsection
