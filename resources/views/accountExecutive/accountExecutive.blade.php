@extends('layouts.aeheader')
@section('content')
<div class="container">
    <div class="row">
        <div class="panel panel-warning">
            <div class="panel-heading">Builder List
                <div class="btn-group pull-right">
                    <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#addBD">Add Builder</button>
                    <a href="{{ URL::to('/') }}/addBuilderProjects" class="btn btn-sm btn-success">Add project</a>
                </div>
            </div>
            <div class="panel-body">
                <table class="table table-responsive">
                    <thead>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Contact</th>
                        <th>Email</th>
                        <th>Website</th>
                        <th>CEO/GM</th>
                        <th>CEO/GM Email</th>
                        <th>Purchase Manager</th>
                        <th>Projects</th>
                    </thead>
                    <tbody>
                        @foreach($builders as $builder)
                        <?php $count = 0; ?>
                        <tr>
                            <td>{{ $builder->builder_name }}</td>
                            <td>{{ $builder->builder_address }}</td>
                            <td>{{ $builder->builder_contact_no }}</td>
                            <td><a href="mailto:{{ $builder->builder_email }}?Subject=Enquiry%20about%20project%20requirements." target="_top">{{ $builder->builder_email }}</a></td>
                            <td><a href="http://{{ $builder->website }}" target="_none">{{ $builder->website }}</a></td>
                            <td>{{ $builder->ceo_gm_name }}</td>
                            <td>{{ $builder->ceo_email }}</td>
                            <td>{{ $builder->purchase_manager }}</td>
                            <td><a href="{{ URL::to('/') }}/builderprojects?builderId={{ $builder->builder_id }}">View <span class="badge">&nbsp;
                            @foreach($projects as $project)
                                @if($project->builder_id == $builder->builder_id)
                                    <?php $count++; ?>
                                @endif
                            @endforeach
                                {{ $count }}
                            &nbsp;</span></a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>


<div class='b'></div>
<div class='bb'></div>
<div class='message'>
  <div class='check'>
    &#10004;
  </div>
  <p>
    Success
  </p>
  <p>
    @if(session('Success'))
    {{ session('Success') }}
    @endif
  </p>
  <button id='ok'>
    OK
  </button>
</div>

<!-- Modal -->
<form method="POST" action="{{ URL::to('/') }}/addBuilderDetails">
    {{ csrf_field() }}
    <div id="addBD" class="modal fade" role="dialog">
      <div class="modal-dialog">
    
        <!-- Modal content-->
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Add Builder</h4>
          </div>
          <div class="modal-body">
            <div class="row">
                <div class="col-md-4">Builder Name</div>
                <div class="col-md-8"><input name="builderName" type="text" class="form-control input-sm" placeholder="Builder Name"></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Office Address</div>
                <div class="col-md-8"><input name="Address" type="text" class="form-control input-sm" placeholder="Head Office Address"></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Contact No.</div>
                <div class="col-md-8"><input name="Contact" type="text" class="form-control input-sm" placeholder="Contact No."></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Email</div>
                <div class="col-md-8"><input name="Email" type="email" class="form-control input-sm" placeholder="Email"></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Website</div>
                <div class="col-md-8"><input name="web" type="text" class="form-control input-sm" placeholder="Website"></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">CEO/GM</div>
                <div class="col-md-8"><input name="ceo" type="text" class="form-control input-sm" placeholder="CEO/GM"></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">CEO Contact No.</div>
                <div class="col-md-8"><input name="ceocontact" type="text" class="form-control input-sm" placeholder="CEO Contact No."></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">CEO Email</div>
                <div class="col-md-8"><input name="ceoEmail" type="email" class="form-control input-sm" placeholder="CEO Email"></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Purchase Manager</div>
                <div class="col-md-8"><input name="purchase" type="text" class="form-control input-sm" placeholder="Purchase Manager"></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Purchase Manager Contact No.</div>
                <div class="col-md-8"><input name="pmContact" type="text" class="form-control input-sm" placeholder="Purchase Manager Contact No."></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Purchase Manager Email</div>
                <div class="col-md-8"><input name="pmEmail" type="email" class="form-control input-sm" placeholder="Purchase Manager Email"></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Purchase Executive</div>
                <div class="col-md-8"><input name="purchaseEx" type="text" class="form-control input-sm" placeholder="Purchase Executive"></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Purchase Executive Contact No.</div>
                <div class="col-md-8"><input name="peContact" type="text" class="form-control input-sm" placeholder="Purchase Executive Contact No."></div>
            </div><br>
            <div class="row">
                <div class="col-md-4">Purchase Executive Email</div>
                <div class="col-md-8"><input name="peEmail" type="email" class="form-control input-sm" placeholder="Purchase Executive Email"></div>
            </div><br>
          </div>
          <div class="modal-footer">
             <div class="row">
                <div class="col-md-6"><input type="submit" value="Save" class="form-control btn btn-success"></div>
                <div class="col-md-6"><input type="reset" value="Clear" class="form-control btn btn-danger"></div>
            </div>
          </div>
        </div>
    
      </div>
    </div>
</form>
@endsection
