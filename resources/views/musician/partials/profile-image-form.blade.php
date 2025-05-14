<div class="card card-primary card-outline">
    <div class="card-body box-profile">
        <div class="row my-2">
            <img id="profileImage" class="w-100"
                src="{{ Auth::user()->profile_image_url ? asset(Auth::user()->profile_image_url) : asset('images/default-image.jpg') }}"
                alt="">
        </div>
        <div class="mb-3">
            {{-- <input name="image" class="form-control" type="file" id="formFile" onchange="loadFile(event)"> --}}
            {{-- With label and feedback disabled --}}
            <x-adminlte-input-file name="image" label="Upload file" type="file" id="formFile" placeholder="Choose an Image..." onchange="loadFile(event)" disable-feedback accept=".jpeg, .jpg, .png, .svg"/>
        </div>
        <div class="progress" style="display: none;">
            <div id="progressBar" class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                aria-valuemin="0" aria-valuemax="100">0%</div>
        </div>
    </div>
</div>
