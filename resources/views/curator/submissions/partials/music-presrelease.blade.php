<div class="col-12">
    <div class="card card-outline card-primary">
        <div class="card-header">
            <h3>Press realease:</h3>
        </div>
        <div class="card-body">
            @php
                $releaseUrl = $music->release_url;
                $isFile = false;
                $fileContent = null;

                // Check if the release_url has a valid file extension
                $extension = pathinfo($releaseUrl, PATHINFO_EXTENSION);

                if (in_array($extension, ['pdf', 'txt', 'doc', 'docx'])) {
                    $isFile = true;
                }
            @endphp

            {{-- Show file preview or text --}}
            @if ($isFile)
                @if ($extension === 'pdf')
                    
                    <iframe src="{{ file_exists(public_path('storage/' . $releaseUrl)) ? asset('storage/' . $releaseUrl) : asset('storage/app/public' . $releaseUrl) }}" width="100%" height="500px"></iframe>
                @elseif ($extension === 'txt')
                    @php
                        $fileContent = file_get_contents(storage_path('app/public/' . $releaseUrl)); // Adjust path if needed
                    @endphp
                    <pre>{{ $fileContent }}</pre>
                @else
                    <p>File type is not previewable</p>
                @endif
            @else
                {{-- Display as plain text --}}
                <p>{{ $releaseUrl }}</p>
            @endif
        </div>

        <div class="card-footer">
            @if ($isFile)
                <div class="col-12">
                    <a href="{{ asset('storage/' . $releaseUrl) }}" download="{{ $music->press_release_download_filename }}">
                        <button class="btn btn-primary">Download File</button>
                    </a>
                </div>
            @endif
        </div>
    </div>
</div>