@extends('layouts.marketingheader')
@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">Category</div>
                    <div class="panel-body" style="height:400px; max-height: 400px; overflow-y: scroll;">
                        <form method="post" action="{{ URL::to('/') }}/addCategory">
                            {{ csrf_field() }}
                            <div class="col-md-4">
                                <input required type="text" placeholder="Category" name="category" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <select class="form-control" required name="measurement">
                                    <option value="" disabled selected>-Select-</option>
                                    <option value="Ton">Ton</option>
                                    <option value="Bags">Bags</option>
                                    <option value="No">No</option>
                                    <option value="Sq.ft">Sq. Ft</option>
                                    <option value="Ltr.">Ltr</option>
                                    <option value="Meter">Meter</option>
                                    <option value="CUM">CUM</option>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Save" class="form-control btn btn-primary">
                            </div>
                        </form>
                        <br><br>
                        <table class="table table-hover">
                            @foreach($categories as $category)
                            <tr id="current{{ $category->id }}">
                                <td>{{ $category->category_name }}</td>
                                <td>
                                <form method="POST" action="{{ URL::to('/') }}/deleteCategory">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $category->id }}" name="id">
                                    <button class="btn btn-sm btn-danger" type="submit">Delete</button></td>
                                </form>
                                <td>
                                    <button class="btn btn-sm btn-primary" onclick="editcategory('{{ $category->id }}')">Edit</button>
                                </td>
                            </tr>
                            <tr class="hidden" id="edit{{ $category->id }}">
                                
                                <td colspan=3>
                                <form method="POST" action="{{ URL::to('/') }}/updateCategory">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $category->id }}" name="id">
                                    <div class="input-group">
                                        <input type="text" name="name" value="{{ $category->category_name }}" class="form-control input-sm">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button></td>
                                        </div>
                                    </div>
                                </form>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="panel panel-danger">
                    <div class="panel-heading">Sub Category</div>
                    <div class="panel-body" style="height:400px; max-height: 400px; overflow-y: scroll;">
                        <form method="post" action="{{ URL::to('/') }}/addSubCategory">
                            {{ csrf_field() }}
                            <div class="col-md-4">
                                <select class="form-control" required name="category">
                                    <option value="">-Select-</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-4">
                                <input required type="text" placeholder="Sub Category" name="subcategory" class="form-control">
                            </div>
                            <div class="col-md-4">
                                <input type="submit" value="Save" class="form-control btn btn-primary">
                            </div>
                        </form>
                        <br><br>
                        <table class="table table-hover">
                            @foreach($subcategories as $subcategory)
                            <tr id="currentsub{{ $subcategory->id }}">
                                <td>{{ $subcategory->category->category_name }}</td>
                                <td>{{ $subcategory->sub_cat_name }}</td>
                                <td>
                                    <form method="POST" action="{{ URL::to('/') }}/deleteSubCategory">
                                        {{ csrf_field() }}
                                        <input type="hidden" value="{{ $subcategory->id }}" name="id">
                                        <button class="btn btn-sm btn-danger" type="submit">Delete</button></td>
                                    </form>
                                <td>
                                <td><button class="btn btn-sm btn-primary" onclick="editsubcategory('{{ $subcategory->id }}')">Edit</button></td>
                            </tr>
                            <tr id="editsub{{ $subcategory->id }}" class="hidden">
                                <td colspan=3>
                                <form method="POST" action="{{ URL::to('/') }}/updateSubCategory">
                                    {{ csrf_field() }}
                                    <input type="hidden" value="{{ $subcategory->id }}" name="id">
                                    <div class="input-group">
                                        <input type="text" name="name" value="{{ $subcategory->sub_cat_name }}" class="form-control input-sm">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-success" type="submit">Save</button></td>
                                        </div>
                                    </div>
                                </form>
                                <td>
                            </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
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
<script>
    function editcategory(arg){
        document.getElementById('current'+arg).className = "hidden";
        document.getElementById('edit'+arg).className = "";
    }
    function editsubcategory(arg){
        document.getElementById('currentsub'+arg).className = "hidden";
        document.getElementById('editsub'+arg).className = "";
    }
</script>
@endsection