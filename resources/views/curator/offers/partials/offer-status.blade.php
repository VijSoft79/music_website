<div class="card p-3 mb-1">
    @if (!$offer->status == 1)
        <div class="row">
            <div class="col-2 ml-3 mt-3">
                <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="cursor: pointer;" class="retract-offer" data-offer-id="{{ Crypt::encryptString($offer->id) }}" title="Retract Invitation">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM8.96963 8.96965C9.26252 8.67676 9.73739 8.67676 10.0303 8.96965L12 10.9393L13.9696 8.96967C14.2625 8.67678 14.7374 8.67678 15.0303 8.96967C15.3232 9.26256 15.3232 9.73744 15.0303 10.0303L13.0606 12L15.0303 13.9696C15.3232 14.2625 15.3232 14.7374 15.0303 15.0303C14.7374 15.3232 14.2625 15.3232 13.9696 15.0303L12 13.0607L10.0303 15.0303C9.73742 15.3232 9.26254 15.3232 8.96965 15.0303C8.67676 14.7374 8.67676 14.2625 8.96965 13.9697L10.9393 12L8.96963 10.0303C8.67673 9.73742 8.67673 9.26254 8.96963 8.96965Z" fill="#DC3545"></path>
                    </g>
                </svg>
            </div>
            <div class="col-8 mt-3">
                <h3 class="align-middle">Pending Invitation</h3>
                <div class="row">
                    <dt class="col-md-12" style="font-size: 22px">
                        Date Sent: {{ date('M d, Y', strtotime($offer->created_at)) }}
                    </dt>

                    <dt class="col-md-12 mb-1 d-flex align-items-center" style="font-size: 20px">
                        Invitation expires on: {{ date('M d, Y', strtotime($offer->expires_at)) }}
                        <i class="fa-solid fa-pen-to-square ml-3 text-primary" title="Edit Expiry" style="cursor: pointer;" id="expire"></i>
                    </dt>

                    <div class="col-md-12">
                        <form action="{{route('curator.offers.expiry', $offer->id)}}" method="post" id="expireInput" style="display: none;">
                            @csrf
                            <div class="row">
                                <div class="col-md-8">
                                    <x-adminlte-input name="edit_expiry" label="Edit Expiry Date" type="date" placeholder="Select a date" class="mr-2" min="{{ \Carbon\Carbon::now()->format('Y-m-d') }}"/>
                                </div>

                                <div class="col-md-4 d-flex align-items-end mb-3">
                                    <button type="submit" class="btn btn-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>

                </div>

            </div>
        </div>
    @elseif ($offer->status == 4)
    <div class="row">
    <div class="col-2">
        <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="cursor: pointer;" class="retract-offer" data-offer-id="{{ Crypt::encryptString($offer->id) }}" title="Retract Invitation">
            <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
            <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
            <g id="SVGRepo_iconCarrier">
                <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM8.96963 8.96965C9.26252 8.67676 9.73739 8.67676 10.0303 8.96965L12 10.9393L13.9696 8.96967C14.2625 8.67678 14.7374 8.67678 15.0303 8.96967C15.3232 9.26256 15.3232 9.73744 15.0303 10.0303L13.0606 12L15.0303 13.9696C15.3232 14.2625 15.3232 14.7374 15.0303 15.0303C14.7374 15.3232 14.2625 15.3232 13.9696 15.0303L12 13.0607L10.0303 15.0303C9.73742 15.3232 9.26254 15.3232 8.96965 15.0303C8.67676 14.7374 8.67676 14.2625 8.96965 13.9697L10.9393 12L8.96963 10.0303C8.67673 9.73742 8.67673 9.26254 8.96963 8.96965Z" fill="#DC3545"></path>
            </g>
        </svg>
    </div>
    <div class="col-10 mt-3">
        <h3 class="align-middle">Invitation Declined by Musician</h3>
    </div>
    </div>
    @else
        <div class="row">
            <div class="col-2">
                <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                    <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                    <g id="SVGRepo_iconCarrier">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C6.47715 22 2 17.5228 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM16.0303 8.96967C16.3232 9.26256 16.3232 9.73744 16.0303 10.0303L11.0303 15.0303C10.7374 15.3232 10.2626 15.3232 9.96967 15.0303L7.96967 13.0303C7.67678 12.7374 7.67678 12.2626 7.96967 11.9697C8.26256 11.6768 8.73744 11.6768 9.03033 11.9697L10.5 13.4393L12.7348 11.2045L14.9697 8.96967C15.2626 8.67678 15.7374 8.67678 16.0303 8.96967Z" fill="#33eb00"></path>
                    </g>
                </svg>
            </div>
            <div class="col-10">
                <h3 class="align-middle">Approved Invitation</h3>
                @if ($offer->status > 0)
                    <dt class="col-md-12" style="font-size: 22px">Date Approved: {{ date('M d, Y', strtotime($offer->accepted_at)) }}</dt>
                @endif
                <dt class="col-md-12" style="font-size: 22px">Due Date: {{ date('M d, Y', strtotime($offer->date_complete)) }}</dt>
                <x-adminlte-button label="change date" data-toggle="modal" data-target="#modalMin" />
            </div>
        </div>
    @endif
</div>

@section('js')
    <script>
        $(document).ready(function() {
            $('#expire').on('click', function() {
                $('#expireInput').slideToggle(); 
            });

            $('.retract-offer').on('click', function() {
                const offerId = $(this).data('offer-id');
                
                Swal.fire({
                    title: 'Retract Invitation?',
                    text: "Are you sure you want to retract this invitation? This action cannot be undone.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, retract it!',
                    cancelButtonText: 'Cancel',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: "{{ route('curator.offers.retract') }}",
                            type: 'POST',
                            data: {
                                offer_id: offerId,
                                _token: '{{ csrf_token() }}'
                            },
                            success: function(response) {
                                if(response.success) {
                                    // Remove the chatbox element immediately
                                    $('#chat-box-wrapper').remove();

                                    // Store flash message for display after redirect
                                    if (response.flash) {
                                        localStorage.setItem('laravelFlash', JSON.stringify(response.flash));
                                    }

                                    // Show success message and then redirect
                                    Swal.fire(
                                        'Retracted!',
                                        response.message, // Use message from controller
                                        'success'
                                    ).then(() => {
                                        // Redirect using the URL from the response
                                        window.location.href = response.redirect_url; 
                                    });
                                } else {
                                    Swal.fire(
                                        'Error!',
                                        response.message,
                                        'error'
                                    );
                                }
                            },
                            error: function(xhr) {
                                Swal.fire(
                                    'Error!',
                                    xhr.responseJSON?.message || 'There was a problem retracting the invitation.',
                                    'error'
                                );
                            }
                        });
                    }
                });
            });
        });
    </script>
@stop
