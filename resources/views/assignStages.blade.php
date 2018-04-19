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
                            <th style="width:15%">Desination</th>
                            <th style="width:15%">Assign Stage</th>
                           <!--  <th style="width:15%">Previously Assigned  Stage </th> -->
                          </thead>

                        <tr>
                            <td>
                           <select id="status"  name="list" class="form-control input-sm">
                                <!-- <select  id="selectle" name="list"> -->
                                    <option disabled selected value="">( SELECT )</option>
                                    <option value="ALL">Select Engineers</option>
                                    @foreach($le as $list)
                                    <option value="{{$list->name}}">{{$list->name}}</option>
                                    @endforeach
                                     @foreach($se as $sales)
                                    <option value="{{$sales->name}}">{{$sales->name}}</option>
                                    @endforeach
                                </select>
                            </td>
                             <td>
                                <select id="status"  name="status" class="form-control input-sm">
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
                            </td>
                        </tr>
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