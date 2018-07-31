<?php
    $group = Auth::user()->group->group_name;
    if($group == "Auditor"){
        $content = "auditor.layout.auditor";
    }else{
        $content = "layouts.app";
    }
?>
@extends($content)
@section('content')
<div class="container">
    <center><h3>Select Category</h3></center>
    <button type="button" class="pull-right btn btn-danger" data-toggle="modal" data-target="#reset">Reset</button>
    <br><br><br>
    <div class="row">
    <?php $i = 0; ?>
    @foreach($categories as $category)
        @if(in_array(strtolower($category->category),$projections))
            <fieldset class="col-md-2">
                <legend style="font-size: 12px;">{{ ucfirst($category->category) }}</legend>
                <center>
                    <div class="btn-group">
                        <a href="{{ URL::to('/') }}/stage?category={{ $category->category }}" class="btn btn-success btn-sm">
                            View
                        </a>
                        <!-- <a href="/reset?category={{ $category->category }}" style="position:relative; bottom:0;right:0;" class="btn btn-sm btn-danger pull-right">Reset</a> -->
                        <button type="button" class="btn btn-sm btn-danger pull-right" data-toggle="modal" data-target="#myModal{{ $category->id }}">Reset</button>
                    </div>
                </center>
            </fieldset>
            <!-- Modal -->
            <div class="modal fade" id="myModal{{ $category->id }}" role="dialog">
                <div class="modal-dialog modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Confirmation</h4>
                    </div>
                    <div class="modal-body">
                    <p>Are you sure you want to reset this planning?</p>
                    </div>
                    <div class="modal-footer">
                    <a href="/reset?category={{ $category->category }}" class="btn btn-danger pull-left">Yes</a>
                    <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                    </div>
                </div>
                </div>
            </div>
        @else
            <fieldset class="col-md-2">
                <legend style="font-size: 12px;">{{ ucfirst($category->category) }}</legend>
                <center>
                    <div class="btn-group">
                        <a href="{{ URL::to('/') }}/stage?category={{ $category->category }}" class="btn btn-success btn-sm disabled">
                            View
                        </a>
                        <!-- <a href="/reset?category={{ $category->category }}" style="position:relative; bottom:0;right:0;" class="btn btn-sm btn-danger pull-right">Reset</a> -->
                        <button type="button" class="btn btn-sm btn-danger pull-right disabled" data-toggle="modal" data-target="#myModal{{ $category->id }}">Reset</button>
                    </div>
                </center>
            </fieldset>
        @endif
        <?php $i++; ?>
        @if($i == 6)
        </div>
        <br>
        <div class="row">
        <?php $i = 0; ?>
        @endif
    @endforeach
    <fieldset class="col-md-2">
        <legend style="font-size: 12px;">&nbsp;</legend>
            <a href="{{ URL::to('/') }}/total" class="btn btn-success btn-sm form-control">
                Total
            </a>
    </fieldset>
    </div>
    <br>
</div>
<!-- Modal -->
<div class="modal fade" id="reset" role="dialog">
    <div class="modal-dialog modal-sm">
    <div class="modal-content">
        <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Confirmation</h4>
        </div>
        <div class="modal-body">
        <p>Are you sure you want to reset this planning?</p>
        </div>
        <div class="modal-footer">
        <a href="/reset?category=all" class="btn btn-danger pull-left">Yes</a>
        <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </div>
    </div>
</div>
@endsection