@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
   
    <div class="row">
        <div class="col-6">
            <h1>Edit {{ $user->name }}</h1>
        </div>
        <div class="col-6 text-right">
            <div class="form-group">
                <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="customSwitch1" {{ $user->special == null || $user->special->is_special == 0 ? '' : 'checked'}}>
                    <label class="custom-control-label" for="customSwitch1">Free Offer Required</label>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="row">
        <div class="col-12">
            <form action="{{ route('admin.curators.update') }}" method="post" class="py-3">
                @csrf
                <input type="hidden" id="custId" name="user_id" value="{{ $user->id }}">

                @include('admin.curators.partials.personal-information-form')

                @include('admin.curators.partials.curator-socials-form')

                @include('admin.curators.partials.additional-information-form')

                <div class="row">
                    <div class="col-md-12">
                        <div class="card card-outline card-danger">
                            <div class="card-header">
                                Change password
                            </div>
                            <div class="card-body">
                                {{-- <x-adminlte-input name="new-password" label="password" type="password"
                                    placeholder="*********" /> --}}
                                {{-- Password field --}}
                                <div class="input-group mb-3">
                                    <input type="password" name="new_password" class="form-control @error('new_password') is-invalid @enderror">

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('new_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                {{-- Confirm password field --}}
                                <div class="input-group mb-3">
                                    <input type="password" name="new_password_confirmation" class="form-control @error('new_password_confirmation') is-invalid @enderror">

                                    <div class="input-group-append">
                                        <div class="input-group-text">
                                            <span class="fas fa-lock {{ config('adminlte.classes_auth_icon', '') }}"></span>
                                        </div>
                                    </div>

                                    @error('new_password_confirmation')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-2">
                    <button type="submit" class="btn btn-block btn-outline-primary">Save</button>
                </div>
            </form>
            <div class="col-2 pb-3">
                <form action="" id="approvalForm">
                    @csrf
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <button type="submit "
                        class="btn btn-{{ $user->is_approve == 0 ? 'success' : 'danger' }} btn-block font-weight-bold"
                        id="approve_btn">
                        {{ $user->is_approve == 0 ? 'Approve Curator' : 'Terminate Account' }}
                    </button>
                </form>
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
    </script>
@stop
