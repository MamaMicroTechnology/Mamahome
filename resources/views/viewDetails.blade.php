@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">Project Details
                </div>
                <div class="panel-body">
                   <div id="first">
                           <table class="table">
                               <tr>
                                   <td>Project Name</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->project_name }}</td>
                               </tr>
                               <tr>
                                   <td>Location</td>
                                   <td>:</td>
                                   <td id="x">
                                    <div class="col-sm-6">
                                        {{ $projectdetails->siteaddress->longitude }}
                                    </div>
                                    <div class="col-sm-6">
                                        {{ $projectdetails->siteaddress->latitude }}
                                    </div>
                                   </td>
                               </tr>
                               <tr>
                                   <td>Road Name</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->road_name }}</td>
                               </tr>
                               <tr>
                                   <td>Municipal Approval</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->municipality_approval }}</td>
                               </tr>
                               <tr>
                                   <td>Other Approvals</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->other_approvals}}</td>
                               </tr>
                               <tr>
                                   <td>Project Status</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->project_status }}</td>
                               </tr>
                               <tr>
                                   <td>Project Type</td>
                                   <td>:</td>
                                   <td>
                                    <div class="form-inline">
                                    <div class="form-group">
                                        <label for="email">Basement:</label>
                                        {{ $projectdetails->basement }}
                                      </div>
                                      
                                      <div class="form-group pull-right">
                                        <label for="pwd">Ground:</label>
                                        {{ $projectdetails->ground }}
                                      </div>
                                  </div>
                                    </td>
                               </tr>
                               <tr>
                                   <td>Project Size</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->project_size }}</td>
                               </tr>
                               <tr>
                                   <td>Budget</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->budget }}</td>
                               </tr>
                               <tr>
                                   <td>Project Image</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->image }}</td>
                               </tr>
                           </table>
                       </div>
                       <div id="second" class="hidden">
                           <label>Owner Details</label>
                           <table class="table">
                               <tr>
                                   <td>Owner Name</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->ownerdetails->owner_name }}</td>
                               </tr>
                               <tr>
                                   <td>Owner Email</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->ownerdetails->owner_email }}</td>
                               </tr>
                               <tr>
                                   <td>Owner Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td>{{ $projectdetails->ownerdetails->owner_contact_no }}</td>
                               </tr>
                           </table>
                       </div>
                       <div id="third" class="hidden">
                           <label>Contractor Details</label>
                           <table class="table">
                               <tr>
                                   <td>Contractor Name</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->contractordetails->contractor_name }}</td>
                               </tr>
                               <tr>
                                   <td>Contractor Email</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->contractordetails->contractor_contact_no }}</td>
                               </tr>
                               <tr>
                                   <td>Contractor Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td>{{ $projectdetails->contractordetails->contractor_email }}</td>
                               </tr>
                           </table>
                       </div>
                       <div id="fourth" class="hidden">
                           <label>Consultant Details</label>
                           <table class="table">
                               <tr>
                                   <td>Consultant Name</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->consultantdetails->consultant_name }}</td>
                               </tr>
                               <tr>
                                   <td>Consultant Email</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->consultantdetails->consultant_email }}</td>
                               </tr>
                               <tr>
                                   <td>Consultant Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td>{{ $projectdetails->consultantdetails->consultant_contact_no }}</td>
                               </tr>
                           </table>
                       </div>
                       <div id="fifth" class="hidden">
                           <label>Site Engineer Details</label>
                           <table class="table">
                               <tr>
                                   <td>Site Engineer Name</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->siteengineerdetails->site_engineer_name }}</td>
                               </tr>
                               <tr>
                                   <td>Site Engineer Email</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->siteengineerdetails->site_engineer_email }}</td>
                               </tr>
                               <tr>
                                   <td>Site Engineer Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td>{{ $projectdetails->siteengineerdetails->site_engineer_contact_no }}</td>
                               </tr>
                           </table>
                       </div> 
                       <div id="sixth" class="hidden">
                           <label>Procurement Details</label>
                           <table class="table">
                               <tr>
                                   <td>Procurement Name</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->procurementdetails->procurement_name }}</td>
                               </tr>
                               <tr>
                                   <td>Procurement Email</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->procurementdetails->procurement_email }}</td>
                               </tr>
                               <tr>
                                   <td>Procurement Contact No.</td>
                                   <td>: <p class="pull-right">+91</p></td>
                                   <td>{{ $projectdetails->procurementdetails->procurement_contact_no }}</td>
                               </tr>
                                <tr>
                                   <td>Remarks</td>
                                   <td>:</td>
                                   <td>{{ $projectdetails->remarks }}</td>
                               </tr>
                           </table>
                       </div>                      
                       <ul class="pager">
                          <li class="previous"><a onclick="pagePrevious()" href="#">Previous</a></li>
                          <li class="next"><a id="next" href="#" onclick="pageNext()">Next</a></li>
                        </ul>
                   </form>
                </div>
            </div>
        </div>
<a href="/allProjects" class="btn btn-primary">Back</a>
    </div>
</div>
<script type="text/javascript">
    var current = "first";
    function pageNext(){
        if(current == 'first'){
            document.getElementById("first").className = "hidden";
            document.getElementById("second").className = "";
            current = "second";
        }else if(current == 'second'){
            document.getElementById("second").className = "hidden";
            document.getElementById("third").className = "";
            current = "third";
        }else if(current == 'third'){
            document.getElementById("third").className = "hidden";
            document.getElementById("fourth").className = "";
            current = "fourth";
        }else if(current == 'fourth'){
            document.getElementById("fourth").className = "hidden";
            document.getElementById("fifth").className = "";
            current = "fifth";
        }else if(current == 'fifth'){
            document.getElementById("fifth").className = "hidden";
            document.getElementById("sixth").className = "";
            current = "sixth";
        }
    }
    function pagePrevious(){
        if(current == 'sixth'){
            document.getElementById("sixth").className = "hidden";
            document.getElementById("fifth").className = "";
            current = "fifth"
        }
        else if(current == 'fifth'){
            document.getElementById("fifth").className = "hidden";
            document.getElementById("fourth").className = "";
            current = "fourth"
        }
        else if(current == 'fourth'){
            document.getElementById("fourth").className = "hidden";
            document.getElementById("third").className = "";
            current = "third"
        }
        else if(current == 'third'){
            document.getElementById("third").className = "hidden";
            document.getElementById("second").className = "";
            current = "second"
        }else if(current == 'second'){
            document.getElementById("second").className = "hidden";
            document.getElementById("first").className = "";
            current = "first";
        }else{
            document.getElementById("next").className = "disabled";
        }
    }
</script>
@endsection