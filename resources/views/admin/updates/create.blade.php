@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Summernote', true)

@section('content_header')
    <h1>Create Update</h1>
@stop

@section('content')

    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-12">
                        <form action="{{ route('admin.updates.save') }}" method="post">
                            @csrf

                            {{-- title --}}
                            <div class="row">
                                <x-adminlte-input name="title" label="Title" placeholder="Update Title..." fgroup-class="col-md-12"
                                    disable-feedback />
                            </div>

                            {{-- Update for --}}
                            <x-adminlte-select label="Update For" name="update_for">
                                <option selected>Select</option>
                                <option value="curator">Curator</option>
                                <option value="musician">Musician</option>
                            </x-adminlte-select>

                            {{-- content --}}
                            <div class="col-md-12 mt-3">
                                <h6 class="font-weight-bold">description</h6>
                                <textarea id="summernote" name="content"></textarea>
                            </div>
                            <div class="col-2 text-end">
                                <button type="submit" class="btn btn-block btn-outline-primary">Save Update</button>
                            </div>
                            
                        </form>
                    </div>
                </div>
            </div>
        </div>

    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 500
            });
        });
    </script>
@stop
