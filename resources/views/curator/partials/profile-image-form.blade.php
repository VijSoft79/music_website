<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="row my-2">
            <img id="profileImage" class="w-100" src="{{ Auth::user()->profile_image_url ? asset(Auth::user()->profile_image_url) : asset('images/default-image.jpg') }}" alt="">
        </div>
        <div class="mb-3">
            
            {{-- <input name="image" class="form-control" type="file" id="formFile" onchange="loadFile(event)"> --}}
            {{-- With label and feedback disabled --}}
            <x-adminlte-input-file name="image" label="Upload file" type="file" id="formFile" value="{{ old('profile_image_url', Auth::user()->profile_image_url) }}" placeholder="Choose an Image..." onchange="loadFile(event)" accept=".jpeg, .jpg, .png, .svg" disable-feedback/>
        </div>
        <div class="progress" style="display: none;">
            <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
    </div>
</div>
@section('js')
    <script>
        var loadFile = function(event) {
            var fileInput = event.target;
            var file = fileInput.files[0];

            var reader = new FileReader();

            reader.onloadstart = function() {
                document.querySelector('.progress').style.display = 'block';
            };

            reader.onprogress = function(e) {
                if (e.lengthComputable) {
                    var percentComplete = (e.loaded / e.total) * 100;
                    document.getElementById('progressBar').style.width = percentComplete + '%';
                    document.getElementById('progressBar').innerHTML = percentComplete.toFixed(2) + '%';
                }
            };

            reader.onload = function() {
                var imgSrc = reader.result;
                document.getElementById('profileImage').src = imgSrc;
                document.querySelector('.progress').style.display = 'none';
            };

            reader.readAsDataURL(file);
        };
    </script>
@stop

