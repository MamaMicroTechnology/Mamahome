@extends('layouts.app')

@section('content')
<div class="col-md-10 col-md-offset-1" >
        <div class="panel panel-primary"  style="overflow-x:scroll">
            <div class="panel-heading" id="panelhead" style="background-color: rgb(244, 129, 31);">

               <h2>
                   <div class="pull-right"></div>
               <h2>Project Details Of 
                   Stage
                   <div class="pull-right">Projects Found</div>
               </h2> 
            </div>
            <div class="panel-body">
                <table class='table table-responsive table-striped' style="color:black" border="1">
                    <thead>
                        <tr>
                            <th style="text-align:center">Project Id</th>
                            <th style="text-align:center">requirnment Date</th>
                            <th style="text-align:center"> Contact Number</th>
                            <th style="text-align:center">Quantity</th>
                            <th style="text-align:center">status</th>
                            <th style="text-align:center">Remark</th>
                            <th style="text-align:center">Action</th>
                        </tr>
                    </thead>
                    <tbody id="mainPanel">
                       
                    </tbody>
                </table>
            </div>
            <div class="panel-footer">
                            </div>
        </div>
    </div>
@endsection
