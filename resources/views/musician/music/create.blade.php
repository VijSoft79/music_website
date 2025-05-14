@extends('adminlte::page')
@section('title', 'music')

@section('plugins.TempusDominusBs4', true)
@section('plugins.BootstrapSwitch', true)

@section('content_header')
    <div class="container row ml-1">
        <h1>Submit Music</h1>
    </div>
@stop

@section('content')
    <div class="container-fluid">
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
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">

                        <form action="{{ route('musician.create.step.one.post') }}" enctype="multipart/form-data" method="post">
                            @csrf
                            <div class="row">
                                {{-- song title --}}
                                <x-adminlte-input value="{{ old('title') }}" name="title" label="Song Title" placeholder="Enter title" fgroup-class="col-md-6" disable-feedback required />

                                {{-- Release Date --}}
                                @php
                                    $config = ['format' => 'L'];
                                @endphp
                                <x-adminlte-input-date value="{{ old('release_date') }}" name="release_date" label="Release Date" autocomplete="off" :config="$config" placeholder="Choose a date..." fgroup-class="col-md-6" type="text" required>
                                    <x-slot name="appendSlot">
                                        <div class="input-group-text bg-gradient-danger">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                    </x-slot>
                                </x-adminlte-input-date>
                                @php
                                    $disabled = '';
                                    if (!Auth::user()->music()->exists()) {
                                        $disabled = 'disabled';
                                    }
                                @endphp
                                {{-- release type --}}
                                <x-adminlte-select name="release_type" label="This Song is:" fgroup-class="col-md-6">
                                    <option value="single" {{ old('release_type') == 'single' ? 'selected' : '' }} >Single</option>
                                    <option value="ep" {{ old('release_type') == 'ep' ? 'selected' : '' }} {{$disabled}}>EP</option>
                                    <option value="album" {{ old('release_type') == 'album' ? 'selected' : '' }} {{$disabled}}>Album</option>
                                    <option value="video" {{ old('release_type') == 'video' ? 'selected' : '' }} {{$disabled}}>Video</option>
                                </x-adminlte-select>

                                {{-- song version --}}
                                <x-adminlte-select name="song_version" label="Song Version" fgroup-class="col-md-6">
                                    <option value="original" {{ old('song_version') == 'original' ? 'selected' : '' }}>Original</option>
                                    <option value="cover" {{ old('song_version') == 'cover' ? 'selected' : '' }}>Cover</option>
                                    <option value="remix" {{ old('song_version') == 'remix' ? 'selected' : '' }}>Remix</option>
                                </x-adminlte-select>

                                {{-- With custom text using data-* config --}}
                                <div class="pl-2 pt-3">
                                    <x-adminlte-input-switch id="EmbargoSwitch" name="wait_for_song_release" label="Check here if you would like curators to wait until your songs release date to share your tune." data-on-text="YES" data-off-text="NO" data-on-color="teal" checked />
                                </div> 

                                <div class="form-group col-md-12" id="EmbargoNote">
                                    <label class="w-100 row" for="note">
                                        <div class="col-6">Embargo Note</div>
                                    </label>
                                    <div class="input-group">
                                        <textarea id="note" name="note" class="form-control" placeholder="Insert Text Here...">{{ old('note') }}</textarea>
                                    </div>
                                </div>
                                

                                {{-- description --}}
                                <x-adminlte-textarea label="Music Description" rows="4" name="description" placeholder="Insert description..." fgroup-class="col-md-12" required>
                                    {{ old('description') }}
                                </x-adminlte-textarea>

                                <div class="pl-2 pt-3">
                                    <x-adminlte-input-switch id="pressRelease" name="pressRelease" label="Don't have a press release?" data-on-text="YES" data-off-text="NO" data-on-color="teal" checked />
                                </div>

                                {{-- embargo/note --}}
                                <div class="form-group col-md-12" id="PressReleaseNote" >
                                    <label class="w-100 row" for="note">
                                        <div class="col-12 text-right"><button class="border-0 bg-grey" id="learn" data-toggle="modal" data-target="#modalMin">learn more</button></div>
                                    </label>
                                    <div class="form-group col-md-12" id="">
                                        <div class="row g-3">
    
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="PressNote0" class="form-label">
                                                        What is being released? (Single, album, music video)
                                                    </label>
                                                    <textarea id="PressNote0" name="PressNote0" class="form-control" placeholder="Insert Text Here...">{{ old('PressNote0') }}</textarea>
                                                </div>
                                            </div>
                                        
                                            <!-- Second Input Group -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fileRelase" class="form-label">
                                                        What is the style or genre of music?
                                                    </label>
                                                    <textarea id="PressNote1" name="PressNote1" class="form-control" placeholder="Insert Text Here...">{{ old('PressNote1') }}</textarea>
                                                </div>
                                            </div>
    
                                           
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="PressNote2" class="form-label">
                                                        Where can people find the release? (Platforms, live venues)
                                                    </label>
                                                    <textarea id="PressNote2" name="PressNote2" class="form-control" placeholder="Insert Text Here...">{{ old('PressNote2') }}</textarea>
                                                </div>
                                            </div>
    
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="PressNote3" class="form-label">
                                                        Why is this release noteworthy?
                                                    </label>
                                                    <textarea id="PressNote3" name="PressNote3" class="form-control" placeholder="Insert Text Here...">{{ old('PressNote3') }}</textarea>
                                                </div>
                                            </div>
    
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="PressNote4" class="form-label">
                                                        What inspired the artist to create this music?
                                                    </label>
                                                    <textarea id="PressNote4" name="PressNote4" class="form-control" placeholder="Insert Text Here...">{{ old('PressNote4') }}</textarea>
                                                </div>
                                            </div>
    
                                              <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="PressNote5" class="form-label">
                                                        What can listeners expect from the release?
                                                    </label>
                                                    <textarea id="PressNote5" name="PressNote5" class="form-control" placeholder="Insert Text Here...">{{ old('PressNote5') }}</textarea>
                                                </div>
                                            </div>
    
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="PressNote6" class="form-label">
                                                        What is the story behind the release?
                                                    </label>
                                                    <textarea id="PressNote6" name="PressNote6" class="form-control" placeholder="Insert Text Here...">{{ old('PressNote6') }}</textarea>
                                                </div>
                                            </div>
    
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="PressNote7" class="form-label">
                                                        What makes the release stand out from others?
                                                    </label>
                                                    <textarea id="PressNote7" name="PressNote7" class="form-control" placeholder="Insert Text Here...">{{ old('PressNote7') }}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- file release --}}
                                <div class="custom-file col-12 mt-1 mb-5" id="fileRelase">
                                    <label for="ReleaseFile" class="">Upload Bio/Press Release</label>
                                    <p class="text-danger m-0">Allowed files: .pdf or .txt</p>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input " id="ReleaseFile" name="releaseFile" accept=".pdf,.doc,.docx,.txt,.xlsx">
                                        <label class="custom-file-label" for="ReleaseFile">Upload File</label>
                                    </div>
                                </div>

                            </div>
                            <button type="submit" class="btn btn-primary px-5 mt-4">Next</button>
                        </form>
                        <div class="d-flex justify-content-end">
                            <x-contact-form />
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $content = App\Models\PageContent::where('title', 'embargo')->first();
    @endphp
    @if (!$content == null)
        <x-adminlte-modal id="modalMin" title="Tip">
            {!! $content->content !!}
        </x-adminlte-modal>
    @endif
@stop

@section('js')
    <script>
        document.getElementById("learn").onclick = function(e) {
            e.preventDefault();
        };


        $(document).ready(function() {
            let pressreleaseSwitch = $('#pressRelease');
            var fileInput = $('#fileRelase');
            var PressNote = $('#PressReleaseNote');
            PressNote.hide();
            // btnSwitch.bootstrapSwitch();
            pressreleaseSwitch.bootstrapSwitch();

            pressreleaseSwitch.on('switchChange.bootstrapSwitch', function(event, state) {
                if (state) {
                    PressNote.hide(); // Hides the embargo element when switch is ON
                    fileInput.show();
                } else {
                    PressNote.show(); // Shows the embargo element when switch is OFF
                    fileInput.hide();
                }
            });

        });

        $(document).ready(function() {
            let EmbargoSwitch = $('#EmbargoSwitch');
            var EmbargoInput = $('#EmbargoNote');
            EmbargoInput.hide();
            EmbargoSwitch.bootstrapSwitch();
            EmbargoSwitch.on('switchChange.bootstrapSwitch', function(event, state) {
                if (state) {
                    EmbargoInput.hide(); // Hides the embargo element when switch is ON
                } else {
                    EmbargoInput.show(); // Shows the embargo element when switch is OFF
                }
            });

        });


        //input label on change
        document.getElementById('ReleaseFile').addEventListener('change', function() {
            var fileName = this.files[0].name;
            var label = this.nextElementSibling;
            label.textContent = fileName;
        });
    </script>
@stop
