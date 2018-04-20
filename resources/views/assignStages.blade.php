@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12 col-md-offset-1">
            <div class="panel panel-default" style="border-color:#f4811f">
                <div class="panel-heading text-center" style="background-color:#f4811f"><b style="color:white;font-size:1.3em">Assign Stages</b>
                    @if(session('Error'))
                        <div class="alert-danger pull-right">{{ session('Error')}}</div>
                    @endif
                <a  href="javascript:history.back()" class="btn btn-sm btn-danger pull-right">Back</a>    
                </div>
                <div class="panel-body">
            
    <form method="POST" action="{{ url('/store')}}" enctype="multipart/form-data">
                    
                    {{ csrf_field() }}
            <div class="panel-body">
                <table class="table table-responsive table-striped table-hover">
                        <thead>
                            <th style="width:15%">Name</th>
                            <th style="width:15%">Designation</th>
                            <th style="width:15%">Assign Stage</th>
                           <!--  <th style="width:15%">Previously Assigned  Stage </th> -->
                          </thead>

                        <tbody>
                            
                           @foreach($users as $user)
                           <tr>
                           <td>{{$user->name}}</td>
                           <td>{{ $user->group_name }}</td>
                           <td>
                              <form method="POST" action="{{ url('/store')}}">
                              <input type="hidden" name="list" value="{{ $user->name }}">
                              {{ csrf_field() }}
                               <select onchange="this.form.submit()" id="status"  name="status" class=" input-sm">
                                   <option value="">--Select--</option>
                                   <option value="Planning">Planning</option>
                                   <option value="Digging">Digging</option>
                                   <option value="Foundation">Foundation</option>
                                   <option value="Pillars">Pillars</option>
                                   <option value="Walls">Walls</option>
                                   <option value="Roofing">Roofing</option>
                                   <option value="Electrical & Plumbing">Electrical &amp; Plumbing</option>
                                   <option value="Plastering">Plastering</option>
                                   <option value="Flooring">Flooring</option>
                                   <option value="Carpentry">Carpentry</option>
                                   <option value="Paintings">Paintings</option>
                                   <option value="Fixtures">Fixtures</option>
                                   <option value="Completion">Completion</option>
                                </select>
                              </form>
                           </td>
                           
                           @endforeach
                            
                                   
                      
                         
                       </tbody>
                       
                    
                </table>
               
            </div>
            </form>                             {{$users->links()}}

        </div>
        </div>
        </div>
        </div>
        </div>


@endsection