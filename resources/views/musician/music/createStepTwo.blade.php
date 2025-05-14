@extends('adminlte::page')
@section('title', 'music')

@section('content_header')
    <div class="container">
        <h1>Submit Music - step two for "{{ $music['title'] }}"</h1>
    </div>

@stop

@section('css')
    <style>
        #learn {
            cursor: pointer;
        }


        .main-footer {
            position: fixed;
            left: 0;
            bottom: 0;
            width: 100%;
            /* background-color: #f8f9fa; */
            text-align: center;
            padding: 1rem;
        }
    </style>
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @elseif(session('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif

    <div class="container">
        <form action="{{ route('musician.create.step.two.post') }}" method="post">
            @csrf
            {{-- <x-adminlte-textarea label="embeded code" name="embeded_url" placeholder="Insert Embed Code..." fgroup-class="col-md-12">
                
            </x-adminlte-textarea> --}}
            @if ($errors->has('embeded_url'))
                <div class="alert alert-danger">
                    {{ $errors->first('embeded_url') }}
                </div>
            @endif

            <div class="mb-3">
                <div class="row">
                    <div class="col-6">
                        <label for="exampleFormControlTextarea1" class="form-label">Embeded Code</label>
                    </div>
                    <div class="col-6 text-right">
                        <button class="border-0 bg-white" id="learn" data-toggle="modal" data-target="#modalMin">learn
                            more</button>
                    </div>
                </div>
                <textarea name="embeded_url" class="form-control" id="exampleFormControlTextarea1" rows="10" required>{{ old('embeded_url') }}</textarea>
            </div>

            <div class="row">
                <div class="col d-flex justify-content-between">
                    <button type="submit" class="btn btn-primary">Next</button>
                </div>
        </form>
        <div class="row justify-content-end">
            <x-contact-form />
        </div>
    </div>
    @php
        $content = App\Models\PageContent::where('title', 'embed-code')->first();
    @endphp
    @if (!$content == null)
        <x-adminlte-modal id="modalMin" title="Tip">
            {!! $content->content !!}
        </x-adminlte-modal>
    @endif

@stop

@section('js')
    <script>
        document.getElementById('exampleFormControlTextarea1').addEventListener('input', function() {
            const value = this.value;
            const iframeCount = (value.match(/<iframe/g) || []).length;

            if (iframeCount > 1) {
                alert('Only one embedded code is allowed.');
                this.value = value.substring(0, value.lastIndexOf('<iframe'));
            }
        });

        document.getElementById("learn").onclick = function(e) {
            e.preventDefault();
        };
    </script>
@stop
