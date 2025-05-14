@extends('adminlte::page')
@section('title', 'Music')

@section('plugins.BsCustomFileInput', true)

@section('content_header')
    <div class="container">
        <h1>Submit Music - Step Four for "{{ $music['title'] }}"</h1>
    </div>
@stop

@section('content')
    <div class="container">
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

        <form action="{{ route('musician.create.step.four.post') }}" enctype="multipart/form-data" method="post">
            @csrf
            <div class="card">
                <div class="card-body mx-4 my-4">
                    <div class="alert alert-info">
                        <h5><i class="icon fas fa-info"></i> Image Requirements:</h5>
                        <ul>
                            <li>The first image will be used as your featured/banner cover for your music</li>
                            <li>Accepted formats: JPEG, PNG, JPG</li>
                            <li>Maximum file size: 3MB</li>
                            <li>Minimum dimensions: 300x300 pixels</li>
                            <li>At least one image is required</li>
                        </ul>
                    </div>
                    <div class="form-group">
                        {{-- First Image Input Group --}}
                        <div class="input-group mb-3" id="imageGroup0">
                            <div class="custom-file col-12">
                                <input name="images[]" type="file" class="custom-file-input music-image-input" id="customFile0" required onchange="validateFileSize(this, 3, 'preview0')">
                                <label class="custom-file-label" for="customFile0">Choose Main Image</label>
                            </div>
                            {{-- Add Remove Button for first image --}}
                            <div class="ml-1">
                                <button type="button" class="btn btn-danger removeBtn" data-remove-target="imageGroup0">Remove</button>
                            </div>
                            <!-- Image preview for the first image -->
                            <div class="col-md-12 text-center mt-2">
                                <img class="w-auto music-image-preview" id="preview0" style="max-width: 250px; display: block; margin: 0 auto;">
                            </div>
                        </div>

                        <div id="additionalLinks"></div>
                        <x-adminlte-button type="button" theme="info" label="Add Another Image" id="addLinkBtn" />
                    </div>
                    <div class="row my-2" id="imagePreviews">
                        <!-- Additional image previews will be displayed here -->
                    </div>
                    {{-- Error message placeholder --}}
                    <div id="imageValidationError" class="alert alert-danger mt-2" style="display: none;">
                        Please upload at least one image before submitting.
                    </div>
                    <div class="col-12 text-right">
                        {{-- Removed data-toggle and data-target, added id --}}
                        <button type="button" class="btn btn-primary" id="triggerSubmitModalBtn">
                            Submit Song
                        </button>
                    </div>

                </div>
            </div>

            <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
                aria-hidden="true">
                <div class="modal-dialog" role="document">
                    <div class="modal-content">
                        <!-- Modal Header -->
                        <div class="modal-header bg-warning">
                            <h5 class="modal-title" id="exampleModalLabel"><i class="fa-solid fa-triangle-exclamation"></i>
                            </h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <!-- Modal Body -->
                        <div class="modal-body">
                            <p class="h5">
                                "Important: Your song is now submitted to our catalog and curators will soon be reaching out to
                                you to offer you coverage!
                                Please be sure check your email and also log back into You Hear Us daily to look over and accept
                                these invitations."
                            </p>
                        </div>
                        <!-- Modal Footer -->
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <div class="row justify-content-end mr-1">
            <x-contact-form />
        </div>
    </div>
@stop

@section('js')
    <script>

        function validateFileSize(input, maxMB, previewId) {
            const file = input.files[0]; // Get the selected file
            const maxSize = maxMB * 1024 * 1024; // Convert MB to bytes

            if (file && file.size > maxSize) {
                alert(`File size exceeds ${maxMB}MB. Please upload a smaller file.`);
                input.value = ''; // Clear the input field
                // Clear preview if file is invalid
                const previewElement = document.getElementById(previewId);
                if (previewElement) {
                    previewElement.src = '';
                }
                return;
            }

            // Preview the image if size is valid
            loadFile(event, previewId);
        }

        function loadFile(event, previewId) {
            const output = document.getElementById(previewId);
            if (output && event.target.files && event.target.files[0]) {
                output.src = URL.createObjectURL(event.target.files[0]);
                output.onload = function() {
                    URL.revokeObjectURL(output.src); // Free memory
                }
            } else if (output) {
                output.src = ''; // Clear preview if no file selected
            }
        }

        let fileIndex = 0;
        const MAX_ADDITIONAL_IMAGES = 3;
        const mainImageInputContainerId = 'imageGroup0'; // ID for the main image group

        // Function to handle image removal
        function handleRemoveImage(event) {
            const currentImageInputs = document.querySelectorAll('.music-image-input').length;

            if (currentImageInputs <= 1) {
                // Replace alert with SweetAlert
                Swal.fire({
                    icon: 'error',
                    title: 'Cannot Remove Image',
                    text: 'At least one image is required for submission.',
                    confirmButtonColor: '#3085d6' // Optional: Customize button color
                });
                // alert('At least one image is required.');
                return; // Prevent removal if it's the last image
            }

            // Find the parent input group to remove
            const button = event.target;
            const targetId = button.getAttribute('data-remove-target');
            let elementToRemove;
            if (targetId) { // For the initial image
                 elementToRemove = document.getElementById(targetId);
            } else { // For dynamically added images
                 elementToRemove = button.closest('.input-group');
            }
           

            if (elementToRemove) {
                 // If removing a dynamically added image, decrement fileIndex
                if (elementToRemove.id !== mainImageInputContainerId) {
                    fileIndex--; 
                     // Re-enable the add button if we are below the limit
                    if (fileIndex < MAX_ADDITIONAL_IMAGES) {
                        document.getElementById('addLinkBtn').removeAttribute('disabled');
                    }
                }
                elementToRemove.remove();
            }
        }

        // Add listener for dynamically added images
        document.getElementById('addLinkBtn').addEventListener('click', function() {
            if (fileIndex >= MAX_ADDITIONAL_IMAGES) {
                alert('You can only add up to 3 additional images');
                return;
            }

            fileIndex++;
            let newInputGroup = document.createElement('div');
            newInputGroup.classList.add('input-group', 'mb-3');
            newInputGroup.id = `imageGroup${fileIndex}`; // Give unique ID to dynamic group

            newInputGroup.innerHTML = `
                <div class="custom-file col-12">
                    <input name="images[]" type="file" class="custom-file-input music-image-input" id="customFile${fileIndex}" onchange="validateFileSize(this, 3, 'preview${fileIndex}')" required>
                    <label class="custom-file-label" for="customFile${fileIndex}">Choose Another Image</label>
                </div>
                <div class="ml-1">
                    {{-- No data-remove-target needed here, handled by closest('.input-group') --}}
                    <button type="button" class="btn btn-danger removeBtn">Remove</button>
                </div>
                <div class="col-md-12 text-center mt-2">
                    <img class="w-auto music-image-preview" id="preview${fileIndex}" style="max-width: 200px; display: block; margin: 0 auto;">
                </div>
            `;

            document.getElementById('additionalLinks').appendChild(newInputGroup);

            // Add remove listener to the new button
            newInputGroup.querySelector('.removeBtn').addEventListener('click', handleRemoveImage);

             // Disable add button if limit reached
            if (fileIndex >= MAX_ADDITIONAL_IMAGES) {
                document.getElementById('addLinkBtn').setAttribute('disabled', 'disabled');
            }
        });

        // Add listener for the initial image's remove button
        document.querySelector(`#${mainImageInputContainerId} .removeBtn`).addEventListener('click', handleRemoveImage);

        // Listener for the button that triggers the submission modal
        document.getElementById('triggerSubmitModalBtn').addEventListener('click', function() {
            const imageInputs = document.querySelectorAll('.music-image-input');
            let imageSelected = false;
            imageInputs.forEach(input => {
                if (input.files && input.files.length > 0 && input.value !== '') {
                    imageSelected = true;
                }
            });

            const errorDiv = document.getElementById('imageValidationError');
            if (imageSelected) {
                 errorDiv.style.display = 'none'; // Hide error if present
                // Manually trigger the modal using Bootstrap's JavaScript API
                $('#exampleModal').modal('show'); 
            } else {
                errorDiv.style.display = 'block'; // Show error message
                // alert('Please upload at least one image before submitting.');
            }
        });

    </script>
@stop
