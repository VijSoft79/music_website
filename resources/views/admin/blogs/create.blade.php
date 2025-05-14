@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Summernote', true)

@section('plugins.Select2', true)

@section('plugins.BsCustomFileInput', true)
@section('plugins.TempusDominusBs4', true)

@section('content_header')
    <h2 class="ml-2">
        Add Blog
    </h2>
@stop

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <form class="py-3" action="{{ route('admin.blog.save') }}" enctype="multipart/form-data" method="post">
                    @csrf
                    <div class="row">

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="exampleInputEmail1">Blog Title</label>
                                <input type="text" name="title" class="form-control" id="exampleInputEmail1"
                                    placeholder="Enter title">
                            </div>
                            <div class="form-group">
                                <x-adminlte-select name="status" label="Select Status">
                                    <option value="draft" selected>draft</option>
                                    <option value="publish">publish</option>
                                </x-adminlte-select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            {{-- With multiple slots, and plugin config parameters --}}
                            @php
                                $config = [
                                    'placeholder' => 'Select multiple categories',
                                    'allowClear' => true,
                                ];
                            @endphp
                            <x-adminlte-select2 id="sel2Category" name="cat[]" label="Categories"
                                label-class="text-danger" igroup-size="sm" :config="$config" multiple>
                                <x-slot name="prependSlot">
                                    <div class="input-group-text bg-gradient-red">
                                        <i class="fas fa-tag"></i>
                                    </div>
                                </x-slot>
                                <x-slot name="appendSlot">
                                    <x-adminlte-button theme="outline-dark" label="Clear"
                                        icon="fas fa-lg fa-ban text-danger" />
                                </x-slot>

                                @foreach (\App\Models\Category::all() as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach

                            </x-adminlte-select2>
                            {{-- Placeholder, date only and append icon --}}
                            @php
                                $config = ['format' => 'L'];
                            @endphp
                            <div style="padding-top: 6px;">
                                <x-adminlte-input-date label="Release Date" name="reminder_date" :config="$config"
                                    placeholder="Choose a date...">
                                    <x-slot name="appendSlot">
                                        <div class="input-group-text bg-gradient-danger">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input-date>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12 mt-3">
                        <textarea id="summernote" name="content"></textarea>
                    </div>

                    <div class="col-4">
                        {{-- Placeholder, sm size, and prepend icon --}}
                        <x-adminlte-input-file name="image" igroup-size="lg" placeholder="Choose a file..." required>
                            <x-slot name="prependSlot">
                                <div class="input-group-text bg-lightblue">
                                    <i class="fas fa-upload"></i>
                                </div>
                            </x-slot>
                        </x-adminlte-input-file>
                    </div>
                    <button type="submit" class="btn btn-success ml-1 mt-3 py-2 px-5">Save Page</button>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'clear']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']], // Add the font size option here
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']],
                    ['insert', ['link', 'picture', 'video']],
                    ['table', ['table']],
                    ['view', ['fullscreen', 'codeview', 'help']],
                ],
                height: 500,
                fontSizes: ['8', '9', '10', '11', '12', '14', '18', '24', '36', '48', '64', '82', '150'],
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact',
                    'Times New Roman', 'Verdana'
                ],
                fontNamesIgnoreCheck: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica',
                    'Impact', 'Times New Roman', 'Verdana'
                ]
            });
        });
    </script>
@stop
