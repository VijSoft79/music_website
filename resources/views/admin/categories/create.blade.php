@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Summernote', true)

@section('content')
    <div class="container-fluid">
        <form class="py-3" action="{{ route('admin.category.save') }}" method="post">
            <div class="row">
                @csrf
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Category Name</label>
                        <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter title">
                    </div>
                </div>
                <div class="col-md-2">
                    <button type="submit" class="btn btn-success">Save Category</button>
                </div>
            </div>
        </form>
    </div>
@stop
