@if ($music->release_url)
    <div class="col-12">
        <div class="card card-outline card-primary">
            <div class="card-header">

                <h3>Press Release:</h3>
            </div>
            <div class="card-body">

                @if ($music->release_url)
                    @php

                        $fileExtension = pathinfo($music->release_url, PATHINFO_EXTENSION);
                        $filePath = storage_path('app/public/' . $music->release_url);
                        $fileContent = null;

                        // check file if exist
                        if (file_exists($filePath)) {

                            if (asset('storage/' . $music->release_url) || file_get_contents(storage_path('app/public/' . $music->release_url))) {
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
                            }
                        }else {
                            echo '<p class="text-center">No file or File is missing</p>';
                        }
                    @endphp
                @endif

            </div>
            <div class="card-footer">
                <div class="col-12">

                    {{-- if music press release is not null and if the file is in server files --}}
                    @if ($music->release_url && file_exists($filePath))
                        @php
                            // Keep this block only for extension check
                            $allowedExtensions = ['pdf', 'doc', 'docx', 'txt', 'xlsx'];
                            $fileExtension = pathinfo($music->release_url, PATHINFO_EXTENSION);
                            // Fallback download link might still need review depending on how temp.txt is generated/used
                            $downloadLink = asset('storage/temp.txt'); 
                        @endphp

                        @if (in_array($fileExtension, $allowedExtensions))
                            <a href="{{ asset('storage/' . $music->release_url) }}" download="{{ $music->press_release_download_filename }}">
                                <button class="btn btn-primary">Download File</button>
                            </a>
                        @else
                            {{-- This fallback downloads temp.txt, named as fallback filename. Check if this is desired behavior --}}
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
