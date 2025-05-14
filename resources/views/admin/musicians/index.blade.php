@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)
@section('plugins.Sweetalert2', true)

@section('content_header')
    <h1 class="ml-2">Musician Lists</h1>
@stop

@section('css')
<style>
    .swap-btn {
        transition: all 0.3s ease;
        border: 3px solid #17a2b8;
        position: relative;
        overflow: hidden;
    }
    
    .swap-btn:hover {
        transform: scale(1.1);
        box-shadow: 0 0 15px rgba(23, 162, 184, 0.5) !important;
        border-color: #138496;
    }
    
    .swap-btn:active {
        transform: scale(0.95);
    }
    
    .swap-btn::after {
        content: '';
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: rgba(255, 255, 255, 0.2);
        transform: rotate(45deg);
        transition: all 0.3s ease;
        opacity: 0;
    }
    
    .swap-btn:hover::after {
        opacity: 1;
    }
    
    @keyframes pulse {
        0% {
            box-shadow: 0 0 0 0 rgba(23, 162, 184, 0.4);
        }
        70% {
            box-shadow: 0 0 0 10px rgba(23, 162, 184, 0);
        }
        100% {
            box-shadow: 0 0 0 0 rgba(23, 162, 184, 0);
        }
    }
    
    .swap-btn {
        animation: pulse 2s infinite;
    }
    </style>
@endsection

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 my-2 d-flex w-100 justify-content-end">
                <a class="btn btn-success" href="{{ route('musician.download') }}"><i class="fas fa-file"></i> Download file</a>
            </div>
            <div class="col-12">
                <div class="card">
                    <div class="card-body table-responsive">
                        @php
                            $heads = ['ID', 'Name', 'Band Name', 'Email', 'Music count', 'Date', 'Status', ['label' => 'Actions', 'no-export' => true, 'width' => 5]];
                            $config = [
                                'data' => $data,
                                'order' => [[1, 'asc']],
                                'columns' => [null, null, null, ['orderable' => false]],
                            ];
                        @endphp

                        <x-adminlte-datatable id="table1" :heads="$heads" hoverable>
                            @foreach ($config['data'] as $row)
                                <tr>
                                    @foreach ($row as $cell)
                                        <td>{!! $cell !!}</td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </x-adminlte-datatable>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal for editing artist names -->
    <div class="modal fade" id="editArtistNameModal" tabindex="-1" role="dialog" aria-labelledby="editArtistNameModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editArtistNameModalLabel">Edit Artist Names</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form id="editArtistNameForm">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" id="userId" name="user_id">
                        <div class="row align-items-center">
                            <div class="col-5">
                                <div class="form-group mb-0">
                                    <label for="contactName">Contact Name</label>
                                    <input type="text" class="form-control" id="contactName" name="name" required>
                                </div>
                            </div>
                            <div class="col-1 text-center mt-3">
                                <button type="button" class="btn btn-outline-secondary rounded-circle p-2 swap-btn" id="swapNamesBtn" title="Swap Names">
                                    <i class="fas fa-sync fa-lg"></i>
                                </button>
                            </div>
                            <div class="col-5">
                                <div class="form-group mb-0">
                                    <label for="bandName">Band Name</label>
                                    <input type="text" class="form-control" id="bandName" name="band_name" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveChangesBtn">Save Changes</button>
                        
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('js')
    <script>
        // Function to handle delete confirmation with SweetAlert
        function confirm_delete(event) {
            event.preventDefault(); // Prevent the default link navigation
            const deleteUrl = event.currentTarget.href; // Get the URL from the link

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete the musician!',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    // If confirmed, navigate to the delete URL
                    window.location.href = deleteUrl;
                }
            });
        }
        $(document).ready(function() {
            // Display session message if it exists
            @if (session('message'))
                Swal.fire({
                    title: 'Success!',
                    text: '{{ session('message') }}',
                    type: 'success',
                    showConfirmButton: true
                });
            @endif

            // Handle modal data
            $('#editArtistNameModal').on('show.bs.modal', function (event) {
                const button = $(event.relatedTarget);
                const userId = button.data('user-id');
                const name = button.data('name');
                const bandName = button.data('band-name');
                
                if (!userId || !name) {
                    Swal.fire({
                        type: 'error',
                        title: 'Error',
                        text: 'Invalid user data provided'
                    });
                    return false;
                }
                
                const modal = $(this);
                modal.find('#userId').val(userId);
                modal.find('#contactName').val(name);
                modal.find('#bandName').val(bandName || '');
            });

            // Handle form submission
            $('#saveChangesBtn').on('click', function(e) {
                e.preventDefault();
                
                const userId = $('#userId').val();
                const contactName = $('#contactName').val().trim();
                const bandName = $('#bandName').val().trim();
                
                if (!userId || !contactName || !bandName) {
                    Swal.fire({
                        type: 'error',
                        title: 'Validation Error',
                        text: 'All fields are required'
                    });
                    return;
                }

                Swal.fire({
                    title: 'Are you sure?',
                    text: "You are about to update the artist's names",
                    type: 'warning',
                    showCancelButton: true,
                    reverseButtons: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, update it!'
                }).then(function(result) {
                    if (result.value) {
                        const formData = $('#editArtistNameForm').serialize();
                        $.ajax({
                            url: '/dashboard/musicians/' + userId + '/update-names',
                            method: 'POST',
                            data: formData,
                            success: function(response) {
                                $('#editArtistNameModal').modal('hide');
                                Swal.fire({
                                    type: 'success',
                                    title: 'Success!',
                                    text: 'Names have been updated successfully',
                                    showConfirmButton: false,
                                    timer: 1500
                                }).then(function() {
                                    location.reload();
                                });
                            },
                            error: function(xhr) {
                                Swal.fire({
                                    type: 'error',
                                    title: 'Error',
                                    text: 'Failed to update names. Please try again.'
                                });
                            }
                        });
                    }
                });
            });

            // Handle swap names with animation
            $('#swapNamesBtn').on('click', function(e) {
                e.preventDefault();
                const $icon = $(this).find('i');
                $icon.addClass('fa-spin');
                
                const contactName = $('#contactName').val();
                const bandName = $('#bandName').val();
                $('#contactName').val(bandName);
                $('#bandName').val(contactName);
                
                setTimeout(() => {
                    $icon.removeClass('fa-spin');
                }, 300);
            });
        });
    </script>
@stop
