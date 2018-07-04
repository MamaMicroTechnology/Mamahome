@extends('layouts.app')
@section('content')
<div class="container">
    <center><h3>Select Category</h3></center>
    <br>
    <div class="row">
    <?php $i = 0; ?>
    @foreach($categories as $category)
        @if(in_array(strtolower($category->category),$projections))
        <a class="col-md-2" href="{{ URL::to('/') }}/stage?category={{ $category->category }}" style="color:black;">
            <div style="padding: 30px;
            background-color: rgba(255, 179, 179,0.4);
            text-align:center;
            border-radius:4px;
            box-shadow: 2px 2px 4px;">
                {{ $category->category }}
            </div>
        </a>
        @else
        <a class="col-md-2" style="color:black;">
            <div style="padding: 30px;
            background-color: rgba(255, 279, 179,0.4);
            text-align:center;
            border-radius:4px;
            box-shadow: 2px 2px 4px;">
                {{ $category->category }}
            </div>
        </a>
        @endif
        <?php $i++; ?>
        @if($i == 6)
        </div>
        <br>
        <div class="row">
        <?php $i = 0; ?>
        @endif
    @endforeach
    </div>
    <br>
</div>

@endsection