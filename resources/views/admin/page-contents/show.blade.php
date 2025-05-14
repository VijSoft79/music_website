
@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Summernote', true)

@section('content_header')

    <h1>{{$pageContent->title}}</h1>

@stop

@section('content')
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif
    <div class="mb-5">
        <form action="{{ route('admin.page.content.update') }}" method="post">
            @csrf
            <div class="form-group">
                <label for="exampleInputEmail1"></label>
                <input type="text" name="title" class="form-control" value="{{old($pageContent->title, $pageContent->title) }}" id="exampleInputEmail1" placeholder="Enter title">
            </div>
            <textarea id="summernote" name="content">{!! old($pageContent->content, $pageContent->content) !!}</textarea>
            <button type="submit" class="btn btn-success">save Curator page</button>
        </form>
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
                fontNames: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Times New Roman', 'Verdana'],
                fontNamesIgnoreCheck: ['Arial', 'Arial Black', 'Comic Sans MS', 'Courier New', 'Helvetica', 'Impact', 'Times New Roman', 'Verdana']
            });
        });
    </script>
@stop

