<div>

    {{-- @if ($errors->any())
        <div class="alert alert-danger">
            <<div class="alert alert-success">
                {{ session('errors') }}
            </div>
        </div>
    @endif --}}

    @if ($music->pressQuestion == null && $music->release_url == null)
        <div class="card">
            <div class="card-header">
                <h3 class="card-title text-bold">
                    Please Add a Press Release or Answer the Following Questions
                </h3>
            </div>
            <form wire:submit.prevent="savePressRelease">
                <div class="card-body mb-3">
                    <div wire:ignore>
                        <div class="pl-2 pt-3">
                            <x-adminlte-input-switch id="pressRelease" wire:model="pressRelease" name="pressRelease" label="Don't have a press release?" data-on-text="YES" data-off-text="NO" data-on-color="teal" />
                        </div>


                        <div class="row">
                            <div class="custom-file col-12 mt-1 mb-5" id="fileRelease">
                                <label for="ReleaseFile">Upload Bio/Press Release</label>
                                <p class="text-danger m-0">Allowed files: .pdf or .txt</p>
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input" id="ReleaseFile" wire:model="releaseFile" accept=".pdf,.doc,.docx,.txt,.xlsx">
                                    <label class="custom-file-label" for="ReleaseFile">Upload File</label>
                                </div>
                            </div>

                            <div class="form-group col-md-12" id="PressReleaseNote">
                                <div class="row g-3">
                                    @foreach (['What is being released? (Single, album, music video)', 'What is the style or genre of music?', 'Where can people find the release? (Platforms, live venues)', 'Why is this release noteworthy?', 'What inspired the artist to create this music?', 'What can listeners expect from the release?', 'What is the story behind the release?', 'What makes the release stand out from others?'] as $index => $question)
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">{{ $question }}</label>
                                                <textarea wire:model.defer="pressQuestions.{{ $index }}" class="form-control" placeholder="Insert Text Here..."></textarea>
                                                @error("pressQuestions.$index")
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Submit Press Release</button>
                </div>
            </form>
        </div>
    @else
        @if ($music->release_url)
            <div class="col-12">
                <div class="card card-outline card-primary">
                    <div class="card-header">
                        <h3>Press realease:</h3>
                    </div>
                    <div class="card-body">

                        @if ($music->release_url)
                            @php
                                $fileExtension = pathinfo($music->release_url, PATHINFO_EXTENSION);

                                $fileContent = null;

                                if ($fileExtension === 'pdf') {
                                    echo '<iframe src="' . asset('storage/' . $music->release_url) . '" width="100%" height="500px"></iframe>';
                                } elseif ($fileExtension === 'txt') {
                                    $fileContent = file_get_contents(storage_path('app/public/' . $music->release_url));
                                    echo '<pre>' . htmlspecialchars($fileContent) . '</pre>';
                                } else {
                                    $fallbackFilePath = storage_path('app/public/temp.txt');
                                    $textContent = $music->release_url;

                                    file_put_contents($fallbackFilePath, $textContent);

                                    $downloadLink = asset('storage/temp.txt');
                                    echo '' . $music->release_url . '';
                                }
                            @endphp
                        @endif

                    </div>
                    <div class="card-footer">
                        <div class="col-12">

                            @if ($music->release_url)
                                @php
                                    $allowedExtensions = ['pdf', 'doc', 'docx', 'txt', 'xlsx'];
                                    $fileExtension = pathinfo($music->release_url, PATHINFO_EXTENSION);
                                    $downloadLink = asset('storage/temp.txt');
                                @endphp

                                @if (in_array($fileExtension, $allowedExtensions))
                                    <a href="{{ asset('storage/' . $music->release_url) }}" download="{{ $music->press_release_download_filename }}">
                                        <button class="btn btn-primary">Download File</button>
                                    </a>
                                @else
                                    <a href="{{ $downloadLink }}" download="{{ $music->press_release_fallback_filename }}">
                                        <button class="btn btn-warning">Download as Text File</button>
                                    </a>
                                @endif
                            @endif


                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="col-12">
                @if ($music->pressQuestion)
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <h3>Press realease:</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <dl class="col-md-6">
                                    <dt>What is being released? (Single, album, music video)</dt>
                                    <dd>{{ $music->pressQuestion->question0 }}</dd>

                                    <dt>What is the style or genre of music?</dt>
                                    <dd>{{ $music->pressQuestion->question1 }}</dd>

                                    <dt>Where can people find the release? (Platforms, live venues)</dt>
                                    <dd>{{ $music->pressQuestion->question2 }}</dd>

                                    <dt>Why is this release noteworthy?</dt>
                                    <dd>{{ $music->pressQuestion->question3 }}</dd>
                                </dl>

                                <dl class="col-md-6">
                                    <dt>What inspired the artist to create this music?</dt>
                                    <dd>{{ $music->pressQuestion->question4 }}</dd>

                                    <dt>What can listeners expect from the release?</dt>
                                    <dd>{{ $music->pressQuestion->question5 }}</dd>

                                    <dt>What is the story behind the release?</dt>
                                    <dd>{{ $music->pressQuestion->question6 }}</dd>

                                    <dt>What makes the release stand out from others?</dt>
                                    <dd>{{ $music->pressQuestion->question7 }}</dd>
                                </dl>
                            </div>


                        </div>

                    </div>
                @endif

            </div>
        @endif
        

    @endif
</div>

@push('scripts')
    <script>
        $(document).ready(function() {
            let pressreleaseSwitch = $('#pressRelease');
            var fileInput = $('#fileRelease');
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
    </script>
@endpush
