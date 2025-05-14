@extends('adminlte::page')

@section('title', 'Dashboard')

@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)

@section('content_header')
    <h1>Admin Dashboard</h1>
    
@stop

@section('content')
    <div class="container-fluid">
        @if ($WalletTotalAmount != 0)
           <div class="row">
                <div class="col-12 d-flex w-100 justify-content-end">
                    <p style="font-size: 24px;">Total Wallet: <b>${{ $WalletTotalAmount }}</b></p>
                </div>
            </div>
        @endif

        <div class="row">
            <div class="col-md-3">
                <div class="card card-primary card-outline">
                    <div class="card-body box-profile">
                        <div class="text-center">
                            @if (isset($user->profile_image_url))
                                <img class="w-100" src="{{ asset($user->profile_image_url) }}" alt="User profile picture">
                            @else
                                <img class="w-100" src="{{ asset('images/default-image.jpg') }}" alt="User profile picture">
                            @endif

                        </div>
                        <h3 class="profile-username text-center">Publication: <b>{{ $user->name }}</b></h3>
                        <form action="" id="approvalForm">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $user->id }}">
                            <button type="submit" class="btn btn-{{ $user->is_approve == 0 ? 'success' : 'danger' }} btn-block font-weight-bold" id="approve_btn">
                                {{ $user->is_approve == 0 ? 'Approve Curator' : 'Terminate Account' }}
                            </button>
                        </form>

                    </div>

                </div>

            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header p-2">
                        <div class="row">
                            <div class="col-6">
                                <h3 class="text-bold">About this Curator</h3>
                            </div>
                            <div class="col-6 text-right">
                                <div class="form-group">
                                    <div class="custom-control custom-switch">
                                        <input type="checkbox" class="custom-control-input" id="customSwitch1" {{ $user->special == null || $user->special->is_special == 0 ? '' : 'checked' }}>
                                        <label class="custom-control-label" for="customSwitch1">Free Offer Required</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <dl class="row">
                            <div class="col-md-6 pb-2">
                                <dt>email:</dt>
                                <dd>{{ $user->email }}</dd>
                            </div>

                            <div class="col-md-6 pb-2">
                                <dt>Website:</dt>
                                <dd>{{ $user->website ? $user->website : 'N/A' }}</dd>
                            </div>

                            <div class="col-md-6 pb-2">
                                <dt>Publication Established Date:</dt>
                                <dd>{{ \Carbon\Carbon::parse($user->date_founded)->format('F d, Y') }}</dd>
                            </div>

                            <div class="col-md-6 pb-2">
                                <dt>Phone Number:</dt>
                                <dd>{{ $user->phone_number ? $user->phone_number : 'N/A' }}</dd>
                            </div>
                            <div class="col-md-6 pb-2">
                                <dt>Location</dt>
                                <dd>{{ $user->location ? $user->location : 'N/A' }}</dd>
                            </div>

                            @if ($user->contribution_bio)
                                <div class="col-md-12">
                                    <dt>User Bio</dt>
                                    <dd>{{ $user->bio }}</dd>
                                </div>
                            @endif

                            @if ($user->contribution_bio)
                                <div class="col-md-12">
                                    <dt>Contribution Bio</dt>
                                    <dd>{{ $user->contribution_bio }}</dd>
                                </div>
                            @endif

                            @if ($user->message_to_admin)
                                <div class="col-md-12">
                                    <dt>Message to the admin</dt>
                                    <dd>{{ $user->message_to_admin }}</dd>
                                </div>
                            @endif
                        </dl>

                        <h3 class="border-bottom border-2"><strong>Socials</strong></h3>
                        <div class="row">
                            <dl class="col-md-6">
                                <dt class="col-md-6">facebook</dt>
                                <dd class="col-md-6">{{ $user->facebook_link != null ? $user->facebook_link : 'N/A' }}</dd>

                                <dt class="col-sm-4">Instagram</dt>
                                <dd class="col-sm-8">{{ $user->instagram_link != null ? $user->instagram_link : 'N/A' }}
                                </dd>

                                <dt class="col-sm-4">Spotify</dt>
                                <dd class="col-sm-8">{{ $user->spotify_link != null ? $user->spotify_link : 'N/A' }}</dd>

                                <dt class="col-sm-4">Tiktok</dt>
                                <dd class="col-sm-8">{{ $user->tiktok_link != null ? $user->tiktok_link : 'N/A' }}</dd>

                                <dt class="col-sm-4">Youtube</dt>
                                <dd class="col-sm-8">{{ $user->youtube_link != null ? $user->youtube_link : 'N/A' }}</dd>

                                <dt class="col-sm-4">Sound Cloud</dt>
                                <dd class="col-sm-8">{{ $user->soundcloud_link != null ? $user->soundcloud_link : 'N/A' }}
                                </dd>


                            </dl>
                            <dl class="col-md-6">
                                <dt class="col-sm-4">Song kick</dt>
                                <dd class="col-sm-8">{{ $user->songkick_link != null ? $user->songkick_link : 'N/A' }}</dd>

                                <dt class="col-sm-4">Band Camp</dt>
                                <dd class="col-sm-8">{{ $user->bandcamp_link != null ? $user->bandcamp_link : 'N/A' }}</dd>

                                <dt class="col-sm-4">Telegram</dt>
                                <dd class="col-sm-8">{{ $user->telegram != null ? $user->telegram : 'N/A' }} </dd>

                                <dt class="col-sm-4">Twitter/X</dt>
                                <dd class="col-sm-8">{{ $user->twitter_link != null ? $user->twitter_link : 'N/A' }}</dd>

                            </dl>
                        </div>
                    </div>
                </div>
            </div>
            {{-- list of invitations --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2><strong>List of Invitations</strong></h2>
                    </div>
                    <div class="card-body">

                        @php
                            $heads = ['ID','Offer Type', 'Music', 'Status', 'Offered Amount', 'Date offered', ['label' => 'Actions', 'no-export' => true, 'width' => 5]];

                            $config = [
                                'data' => $data,
                                'order' => [[1, 'desc']],
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

            {{-- curator Template list --}}
            <div class="col-md-12">
                @include('admin.curators.partials.list-of-templates')
            </div>

            {{-- curator transaction list --}}
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h2><strong>List of Transactions</strong></h2>
                    </div>
                    <div class="card-body">

                        @php
                            $heads = ['ID','amount', 'type', 'Status', 'offer_id', 'created_at'];

                            $config = [
                                'data' => $transactions,
                                'order' => [[1, 'desc']],
                                'columns' => [null, null, null, ['orderable' => false]],
                            ];
                        @endphp

                        <x-adminlte-datatable id="table3" :heads="$heads" hoverable>
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
@stop

@section('js')
    <script>
        $(document).ready(function() {
            let btn = $('#approve_btn');
            $('#approvalForm').click(function(e) {
                e.preventDefault();

                let userId = $('input[name="user_id"]').val();
                let actionUrl = "{{ route('admin.curators.approve') }}";

                $.ajax({
                    url: actionUrl,
                    type: 'post',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        user_id: userId
                    },
                    success: function(response) {
                        if (btn.hasClass('btn-success')) {
                            alert('Curator has been Approved');
                            btn.removeClass('btn-success');
                            btn.addClass('btn-danger');
                            btn.text("Terminate Curator")
                        } else {
                            alert('Curator has been Terminated');
                            btn.removeClass('btn-danger');
                            btn.addClass('btn-success');
                            btn.text("Approve Curator")
                        }

                    },
                    error: function(error) {
                        console.log(error.responseJSON);
                    }
                });
            });

            $(document).on('change', '#customSwitch1', function() {
                let userspecial = '{{ $user->id }}';
                let special = false;
                if ($(this).is(':checked')) {
                    special = 1;
                } else {
                    special = 0;
                }
                $.ajax({
                    url: "{{ route('add.is.special') }}",
                    type: 'post',
                    data: {
                        _token: $('input[name="_token"]').val(),
                        user_id: userspecial,
                        special: special
                    },
                    success: function(response) {
                        alert(response.message);
                    },
                    error: function(error) {
                        console.log(error.responseJSON);
                    }
                });

            });


        });
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
