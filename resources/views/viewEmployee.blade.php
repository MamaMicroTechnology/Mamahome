@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default" style="border-color: green;">
                <div class="panel-heading"  style="background-color: green;color:white;padding-bottom: 20px;">
                    {{ $user->employeeId }} : {{ $user->name }}
            <a href="{{ URL::to('/') }}/humanresources" class="btn btn-danger input-sm pull-right">Back</a>
                </div>
                <div class="panel-body">
                    <center>
                        <img style="border-radius:50%; height:150px; width:150px;" data-toggle="modal" data-target="#myModal" src="{{ URL::to('/') }}/public/profilePic/{{ $user->profilepic }}">
                        <br>
                        <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title"> {{ $user->employeeId }} : {{ $user->name }}</h4>
        </div>
        <div class="modal-body">
          <img style=" height:150px; width:150px;" src="{{ URL::to('/') }}/public/profilePic/{{ $user->profilepic }}">

        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
                        @if($user->confirmation == 0)
                            <p>User has not accepted the terms & policies</p>
                        @elseif($user->confirmation == 1)
                            <form method="POST" action="{{ URL::to('/') }}/approve">
                            {{ csrf_field() }}
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <input type="submit" value="Approve" class="btn btn-success">
                            </form>
                        @else
                            <p>User has been approved</p>
                        @endif
                    </center>
                    <br><br>
                    <table class="table table-responsive">
                        <tr>
                          <!--   <td>Name</td> -->
                            <td>: {{ $user->name }}</td>
                            <td>User Id Of Mama</td>
                            <td>: {{ $user->email }}</td>
                        </tr>
                        <tr>
                            <td>Department</td>
                            <td>: {{ $user->department->dept_name }}</td>
                            <td>Designation</td>
                            <td>
                                : {{ $user->group->group_name }}
                            </td>
                        </tr>
                        @if($details != NULL)
                        <tr>
                            <td>Date Of Joining</td>
                            <td>: {{ date('d-m-Y',strtotime($details->date_of_joining)) }}</td>
                            <td>Aadhar No.</td>
                            <td>: {{ $details->adhar_no }}</td>
                        </tr>
                        <tr>
                            <td>Date Of Birth</td>
                            <td>: {{ date('d-m-Y',strtotime($details->dob)) }}</td>
                            <td>Blood Group</td>
                            <td>: {{ $details->blood_group }}</td>
                        </tr>
                        <tr>
                            <td>Father's Name</td>
                            <td>: {{ $details->fathers_name }}</td>
                            <td>Mother's Name</td>
                            <td>: {{ $details->mothers_name }}</td>
                        </tr>
                        <tr>
                            <td>Spouse Name</td>
                            <td>: {{ $details->spouse_name }}</td>
                            <td>Office Phone No.</td>
                            <td>: {{ $details->office_phone }}</td>
                        </tr>
                        <tr>
                            <td>Phone No.</td>
                            <td>: {{ $user->contactNo }}</td>
                            <td>Alternative Phone No.</td>
                            <td>: {{ $details->alt_phone }}</td>
                        </tr>
                        <tr>

                            <td>Official Email-id(gmail)</td>
                            <td>: {{ $details->official_email }}</td>
                            <td>Official Email-id(mamahome360.com)</td>
                            <td>: {{ $details->mh_email }}</td>
                        </tr>
                        <tr>
                            <td>Personal Email-id</td>
                            <td>: {{ $details->personal_email }}</td>
                        </tr>
                        <tr>
                            <td>Permanent Address</td>
                            <td>: {{ $details->permanent_address }}</td>
                            <td>Present Address</td>
                            <td>: {{ $details->temporary_address }}</td>
                        </tr>
                        <tr>
                            <td>Permanent Address Proof</td>
                            <td>: <img onclick="display('address1')" id="address1" height="200" width="200" alt="{{ $user->name }}" class="img img-responsive myImg" src="{{ URL::to('/') }}/public/employeeImages/{{ $details->permanent_address_proof }}"></td>
                            <td>Present Address Proof</td>
                            <td>: <img onclick="display('address2')" id="address2" height="200" width="200" alt="{{ $user->name }}" class="img img-responsive myImg" src="{{ URL::to('/') }}/public/employeeImages/{{ $details->temporary_address_proof }}"></td>
                        </tr>
                        <tr>
                            <td>Emergency Contact Name</td>
                            <td>{{ $details->emergency_contact_name }}</td>
                            <td>Emergency Contact No.</td>
                            <td>{{ $details->emergency_contact_no }}</td>
                        </tr>
                        <tr>
                            <td>Call Confirmation Audio</td>
                            <td><audio controls style="width:100%;">
                                    <source src="{{ URL::to('/') }}/public/employeeAudios/{{ $details->confirmation_call }}" type="audio/ogg">
                                    <source src="{{ URL::to('/') }}/public/employeeAudios/{{ $details->confirmation_call }}" type="audio/mpeg">
                                </audio>
                            </td>
                            <td>Call Confirmation Audio 2</td>
                            <td><audio controls style="width:100%;">
                                    <source src="{{ URL::to('/') }}/public/employeeAudios/{{ $details->confirmation_call2 }}" type="audio/ogg">
                                    <source src="{{ URL::to('/') }}/public/employeeAudios/{{ $details->confirmation_call2 }}" type="audio/mpeg">
                                </audio>
                            </td>
                        </tr>
                        <tr>
                            <td>Emergency Contact 2 Name</td>
                            <td>{{ $details->emergency_contact2_name }}</td>
                            <td>Emergency Contact 2 No.</td>
                            <td>{{ $details->emergency_contact2_no }}</td>
                        </tr>
                        <tr>
                            <td>Curriculum Vite</td>
                            <td>
                                @if($details->curriculum_vite != NULL)
                                <a href="https://view.officeapps.live.com/op/embed.aspx?src={{ URL('/') }}/public/employeeImages/{{ $details->curriculum_vite }}" class="btn btn-success btn-xs" target="_blank">Click Here To View CV</a>
                                @else
                                <i>*No CV provided*</i>
                                @endif
                            </td>
                            <td>Aadhar Image</td>
                            <td>
                                @if($details->aadhar_image != NULL)
                                <img onclick="display('aadhar')" id="aadhar" height="200" width="200" alt="{{ $user->name }}" class="img img-responsive myImg" src="{{ URL::to('/') }}/public/employeeImages/{{ $details->aadhar_image }}">
                                @else
                                <i>*No aadhar image uploaded*</i>
                                @endif
                            </td>
                        </tr>
                        @endif
                    </table>
                    @if($bankdetails != NULL)
                    <table class="table table-responsive">
                        <h3><center>Bank Account Details</center></h3>
                        <tr>
                            <td>Account Holder Name</td>
                            <td>{{ $bankdetails->accountHolderName }}</td>
                            <td>Bank Name</td>
                            <td>{{ $bankdetails->bank_name }}</td>
                        </tr>
                        <tr>
                            <td>Account No.</td>
                            <td>{{ $bankdetails->accountNo }}</td>
                            <td>IFSC</td>
                            <td>{{ $bankdetails->ifsc }}</td>
                        </tr>
                        <tr>
                            <td>Branch Name</td>
                            <td>{{ $bankdetails->branchName }}</td>
                            <td>Pan Card No.</td>
                            <td>{{ $bankdetails->pan_card_no }}</td>
                        </tr>
                        <tr>
                            <td>Passbook Image</td>
                            <td>
                                @if($bankdetails->passbook != NULL)
                                <img onclick="display('passbook')" id="passbook" height="200" width="200" alt="{{ $user->name }}" class="img img-responsive myImg" src="{{ URL::to('/') }}/public/employeeImages/{{ $bankdetails->passbook }}">
                                @else
                                <i>*No image uploaded*</i>
                                @endif
                            </td>
                            <td>Pan Card Image</td>
                            <td>
                                @if($bankdetails->pan_card_image != NULL)
                                <img onclick="display('pan')" id="pan" height="200" width="200" alt="{{ $user->name }}" class="img img-responsive myImg" src="{{ URL::to('/') }}/public/employeeImages/{{ $bankdetails->pan_card_image }}">
                                @else
                                <i>*No pan card image*</i>
                                @endif
                                </td>
                        </tr>
                    </table>
                    @endif
                    <table class="table table-responsive">
                        <h3><center>Asset Info.</center></h3>
                        <thead><th>Asset Type</th><th>Description</th></thead>
                        <tbody>
                            @foreach($assets as $asset)
                            <tr>
                                <td>{{ $asset->asset_type }}</td>
                                <td>{{ $asset->description }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <table class="table table-responsive">
                        <h3><center>CERTIFICATES</center></h3>
                        <thead><th>Type</th><th>Image</th></thead>
                        <tbody>
                            @foreach($certificates as $certificate)
                            <tr>
                                <td>{{ $certificate->type }}</td>
                                <td><img onclick="display('certificate{{$certificate->id}}')" id="certificate{{$certificate->id}}" height="200" width="200" alt="{{ $user->name }}" class="img img-responsive myImg" src="{{ URL::to('/') }}/public/employeeImages/{{ $certificate->location }}"></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="myModal" class="imgModal">

  <!-- The Close Button -->
  <span class="imgClose">&times;</span>

  <!-- Modal Content (The Image) -->
  <img class="imgModal-content" id="img01">

  <!-- Modal Caption (Image Text) -->
  <div id="caption"></div>
</div>

  
</div>

</body>
</html>

@endsection
