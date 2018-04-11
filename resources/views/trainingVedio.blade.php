@extends('layouts.app')

@section('content')
<div class="col-md-3"></div>
<div class="col-md-6">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Upload Training Vedio here</b>
                    @if(session('ErrorFile'))
                        <div class="alert-danger pull-right">{{ session('ErrorFile' )}}</div>
                    @endif 
                </div>
                <div class="panel-body">
<form method="POST" action="{{ URL::to('/') }}/uploadvedio" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <table class="table">
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
                                    <td><input type="file" name="upload" required class="form-control input-sm" accept="application/pdf">
                                    </td>
                                    
                                    <td><button type="submit" class="btn btn-success input-sm">Upload Vedio</button></td>
                                </tr>
                            </table>
                        </form>
                        
            	</div>
			</div>
</div>
@endsection