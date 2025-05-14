@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Summernote', true)
@section('plugins.Select2', true)
@section('plugins.BsCustomFileInput', true)

@section('content_header')
    <h1>{{ $post->title }}</h1>
@stop


@section('content')
    <div class="container-fluid">
    @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                </div>
            @endif

        <form class="py-3" action="{{ route('admin.blog.save') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="row">

                <div class="col-md-6">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Blog Title</label>
                        <input type="text" value="{{$post->title}}" name="title" class="form-control" id="exampleInputEmail1" placeholder="Enter title">
                    </div>
                </div>
                <div class="col-md-6">
                    {{-- With multiple slots, and plugin config parameters --}}
                    @php
                        $config = [
                            'placeholder' => 'Select multiple categories',
                            'allowClear' => true,
                            'enable-old-support' => true,
                            'value' => old('cat', ['1'])
                        ];
                    @endphp
                    <x-adminlte-select2 id="sel2Category" name="cat[]" label="Categories" label-class="text-danger" igroup-size="sm"  :config="$config" multiple>
                        <x-slot name="prependSlot">
                            <div class="input-group-text bg-gradient-red">
                                <i class="fas fa-tag"></i>
                            </div>
                        </x-slot>
                        <x-slot name="appendSlot">
                            <x-adminlte-button theme="outline-dark" label="Clear" icon="fas fa-lg fa-ban text-danger" />
                        </x-slot>
                        <option value="1">music</option>
                    </x-adminlte-select2>
                </div>
            </div>

            <div class="col-md-12 mt-3">
                <textarea id="summernote" name="content"></textarea>
            </div>

            <div class="col-4">
                {{-- Placeholder, sm size, and prepend icon --}}
                <x-adminlte-input-file name="image" igroup-size="lg" placeholder="Choose a file...">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-lightblue">
                            <i class="fas fa-upload"></i>
                        </div>
                    </x-slot>
                </x-adminlte-input-file>
            </div>
            <button type="submit" class="btn btn-success">save Page</button>
        </form>
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


