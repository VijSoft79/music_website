@extends('adminlte::page')

@section('title', 'Dashboard')
@section('plugins.TempusDominusBs4', true)

@section('content_header')
    <h1>Submission Overview</h1>
@stop
@section('css')
    <style>
        .main-footer {
            position: absolute;
            left: 0;
            bottom: 0;
            width: 100%;

            /* background-color: #f8f9fa; */
            text-align: center;
            padding: 1rem;
        }
    </style>
@stop

@section('content')
    <div class="container-fluid pb-3">
        @if (session('message'))
            <div class="col-12">
                <x-adminlte-alert theme="success" title="Success">
                    {{ session('message') }}
                </x-adminlte-alert>
            </div>
        @endif
        @if ($errors->any())
            <div class="alert alert-danger col-12">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">

            @php
                preg_match('/<iframe[^>]*>.*?<\/iframe>/', $music->embeded_url, $matches);

                $music->embeded_url = isset($matches[0]) ? $matches[0] : null;
            @endphp

            <div class="col-12">
                @if (strpos($music->embeded_url, 'youtube') !== false || strpos($music->embeded_url, 'youtu.be') !== false)
                    <div class="card">
                        <div class="card-body ">

                            <h3 class="profile-username text-center font-weight-bold mb-3">{{ $music->title }}</h3>
                            <div class="w-100 mx-auto" style="display: flex; justify-content: center; align-items: center;">
                                {!! $music->embeded_url !!}
                            </div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-3">
                @if (strpos($music->embeded_url, 'youtube') === false && strpos($music->embeded_url, 'youtu.be') === false)
                    <div class="card mx-10">
                        <div class="card-body">
                            <h3 class="profile-username text-center font-weight-bold mb-3">{{ $music->title }}</h3>
                            <div style="" id="embed-container">
                                {!! $music->embeded_url !!}
                            </div>
                        </div>
                    </div>
                @endif
                @include('curator.submissions.partials.about-artist')

            </div>

            <div class="col-md-9">
                @include('curator.submissions.partials.music-details')

                <div class="col-12">
                    @include('curator.submissions.partials.music-images')
                    {{-- Preview press release --}}
                    @if ($music->release_url)
                        @include('curator.submissions.partials.music-presrelease')
                    @else
                        @include('curator.submissions.partials.press-questions')
                    @endif

                    <div class="row">
                        <div class="col-8"></div>
                        <div class="col-4 mb-5">
                            <button type="button" class="btn btn-block bg-gradient-success btn-lg" data-toggle="modal"
                                data-target="#sendOffer">Send Invitation</button>
                            {{-- <input type="hidden" name="_token" value="{{ csrf_token() }}"> --}}
                            <button type="button" id="decline" class="btn btn-block bg-gradient-danger btn-lg">Decline
                                Song</button>
                            <x-adminlte-button data-target="#reportmusicForm" data-toggle="modal" id="reportMusic"
                                label="Report" class="btn btn-block bg-gradient-warning btn-lg mb-5"
                                icon="fa-solid fa-triangle-exclamation" />
                            {{-- <i class="fa-solid fa-triangle-exclamation"></i> --}}
                        </div>
                    </div>
                </div>
            </div>
            {{-- @dd($offerTemplates) --}}
        </div>

        {{-- choosing this song modal --}}
        <div class="modal fade" id="sendOffer" style="display: none; padding-right: 17px;" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">Send Invitation</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        @if (Auth::user()->OfferTemplate->count() != 0)
                            <select class="form-control" name="" id="offerTemplateSelect">
                                <option value="">Select Invitation template</option>

                                @foreach ($offerTemplates as $offerTemplate)
                                    <option value="{{ $offerTemplate->id }}">{{ $offerTemplate->basicOffer->name }}</option>
                                @endforeach

                            </select>
                            <div class="d-none" id="formController">
                                <form method="post" action="{{ route('curator.offers.send-offer') }}">
                                    @csrf
                                    <input type="hidden" id="musicId" name="musicId" value="{{ $music->id }}">
                                    <input type="hidden" id="templateID" name="templateID" value="">
                                    Standard Invitation

                                    <div class="form-group">
                                        <label>Title</label>
                                        <input name="basicTitle" id="basicTitle" type="text" class="form-control"
                                            placeholder="Enter ..." disabled>
                                    </div>

                                    <div class="form-group">
                                        <label>Offer Price</label>
                                        <input name="offerPrice" id="offerPrice" type="text" class="form-control"
                                            placeholder="Enter ..." disabled>
                                    </div>

                                    <div class="form-group">
                                        <label>Offer Type</label>
                                        <input name="offertype" id="offertype" type="text" class="form-control"
                                            placeholder="Enter ..." disabled>

                                    </div>

                                    <div class="form-group">
                                        <label>Intro Message</label>
                                        <textarea name="intromessage" id="intromessage" class="form-control" rows="3" placeholder="Enter ..." disabled></textarea>
                                    </div>

                                    {{-- premium offer --}}
                                    <div id="additionOffer" class="d-none">
                                        Alternative Invitation
                                        <div class="form-group">
                                            <label>Title</label>
                                            <input name="premium[]" id="premiumTitle" type="text" class="form-control"
                                                placeholder="Enter ..." disabled>
                                        </div>

                                        <div class="form-group">
                                            <label>Offer Price</label>
                                            <input name="premium[]" id="premiumPrice" type="text"
                                                class="form-control" placeholder="Enter ..." disabled>
                                        </div>

                                        <div class="form-group">
                                            <label>Offer Type</label>
                                            <input name="premium[]" id="premiumoffertype" type="text"
                                                class="form-control" placeholder="Enter ..." disabled>
                                        </div>

                                        <div class="form-group">
                                            <label hidden>Intro Message</label>
                                            <textarea name="premium[]" id="premiumintromessage" class="form-control" rows="3" placeholder="Enter ..."
                                                disabled hidden></textarea>
                                        </div>
                                    </div>

                                    {{-- Placeholder, date only and append icon --}}
                                    @php
                                        $config1 = ['format' => 'L'];
                                    @endphp

                                    <div class="col-12" id="expDate">
                                        <x-adminlte-input-date label="Invitation expiry" autocomplete="off" required
                                            name="expires_at" :config="$config1"
                                            value="{{ Carbon\Carbon::now()->addMonth(1)->format('m/d/Y') }}"
                                            placeholder="Choose a date...">
                                            <x-slot name="appendSlot">
                                                <div class="input-group-text bg-gradient-danger">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-date>
                                    </div>
                                    <div class="form-group">
                                        <div class="row">

                                            <div class="col-6" id="marketSpendsStandard" hidden>
                                                <label for="marketing_option_standard">Marketing spend option <span
                                                        class="text-success">(for Standard)</span></label>
                                                <select class="form-control" name="marketing_option_standard"
                                                    id="marketingOption">
                                                    <option value="" selected>Select Option</option>
                                                    <option value="notrequired">Don't Require</option>
                                                    <option value="required">Required</option>
                                                    <option value="optional">Optional</option>
                                                </select>
                                            </div>

                                            <div class="col-6" id="marketSpendsPremium" hidden>
                                                <label for="marketing_option_premium">Marketing spend option <span
                                                        class="text-teal">(for Premium)</span></label>
                                                <select class="form-control" name="marketing_option_premium"
                                                    id="marketingOption">
                                                    <option value="" selected>Select Option</option>
                                                    <option value="notrequired">Don't Require</option>
                                                    <option value="required">Required</option>
                                                    <option value="optional">Optional</option>
                                                </select>
                                            </div>

                                        </div>

                                    </div>


                                    @php
                                        $config2 = ['format' => 'L'];
                                    @endphp
                                    <div>
                                        <p class="text-danger m-0 fw-bold text-bold">Reminder: the release date will be on
                                            {{ \Carbon\Carbon::parse($music->release_date)->format('F d, Y') }}</p>
                                        <label for="date_complete">Expected Date to Complete</label>
                                        <x-adminlte-input-date id="date_complete" autocomplete="off" required
                                            name="date_complete" :config="$config2" placeholder="Choose a date...">

                                            <x-slot name="appendSlot">
                                                <div class="input-group-text bg-gradient-danger">
                                                    <i class="fas fa-calendar-alt"></i>
                                                </div>
                                            </x-slot>
                                        </x-adminlte-input-date>
                                    </div>



                                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary">Send Invitation</button>
                                </form>
                            </div>
                        @else
                            {{-- do this if none --}}
                        @endif
                    </div>
                </div>

            </div>

        </div>


        <x-adminlte-modal id="reportmusicForm" title="Report Music" theme="warning" size='lg' aria-hidden="true"
            aria-labelledby="contactFormModalLabel">
            <form action="{{ route('curator.report') }}" method="post">
                @csrf
                <input name="musicId" value="{{ $music->id }}" hidden>
                <x-adminlte-textarea name="concern" label="Concern" rows=5 igroup-size="sm" placeholder="Message Body">

                </x-adminlte-textarea>

                <x-adminlte-button class="btn-flat" type="submit" label="Submit" theme="success" />
            </form>
        </x-adminlte-modal>
    @stop




    @section('js')
        <script>
            $(document).ready(function() {
                $('#offerTemplateSelect').change(function() {
                    let formContainer = $('#formController');
                    let premiumFormContainer = $('#additionOffer');
                    let offerTemplateId = $(this).val();

                    if (offerTemplateId) {
                        $.ajax({
                            url: '/dashboard/curator/submissions/get-template/' + offerTemplateId,
                            method: 'GET',
                            success: function(response) {
                                formContainer.removeClass('d-none');
                                formContainer.addClass('d-block');
                                $('#templateID').val(response.template_id);
                                $('#intromessage').val(response.basicOffer.introduction_message);
                                $('#basicTitle').val(response.basicOffer.name);
                                $('#offerPrice').val(response.basicOffer.offer_price);
                                $('#offertype').val(response.basicOffer.offer_type);

                                // console.log('response', response)
                                // console.log('check',response.market_spend);

                                if (response.market_spend_premium == undefined || response
                                    .market_spend_premium == null || response.market_spend_premium
                                    .length === 0) {
                                    $('#marketSpendsPremium').attr('hidden', true);

                                } else {
                                    $('#marketSpendsPremium').removeAttr('hidden');

                                }

                                if (response.market_spend_standard == undefined || response
                                    .market_spend_standard == null || response.market_spend_standard
                                    .length === 0) {
                                    $('#marketSpendsStandard').attr('hidden', true);

                                } else {
                                    $('#marketSpendsStandard').removeAttr('hidden');

                                }

                                if (response.hasOwnProperty('premiumOffer')) {
                                    premiumFormContainer.removeClass('d-none');
                                    premiumFormContainer.addClass('d-block');

                                    $('#premiumTitle').val(response.premiumOffer.name);
                                    $('#premiumintromessage').val(response.premiumOffer
                                        .introduction_message);
                                    $('#premiumPrice').val(response.premiumOffer.offer_price);
                                    $('#premiumoffertype').val(response.premiumOffer.offer_type);

                                } else {
                                    // $('#premiumTitle').val('');
                                    premiumFormContainer.removeClass('d-block');
                                    premiumFormContainer.addClass('d-none');
                                }
                                // console.log(response);
                            },
                            error: function(xhr, status, error) {
                                console.error(xhr.responseText);
                            }
                        });
                    } else {
                        formContainer.addClass('d-none');
                        formContainer.removeClass('d-block');
                    }
                });

                window.onload = function() {
                    var embeddedElements = document.querySelectorAll('#embed-container iframe');
                    embeddedElements.forEach(function(element) {
                        element.style.maxWidth = '250px'; // Set desired width
                        element.style.maxHeight = '300px'; // Set desired height

                        // element.style.minWidth = '240px';
                        // element.style.minHeight = '100px'
                    });
                };

                let formContainer = $('#decline');
                formContainer.on('click', function() {
                    let result = confirm("You sure You want to decline this Music?");
                    if (result === true) {
                        $.ajax({
                            url: '{{ route('curator.offers.decline') }}',
                            method: 'POST',
                            data: {
                                _token: $('input[name="_token"]').val(),
                                musicId: '{{ $music->id }}',
                            },
                            success: function() {
                                window.location.replace(
                                    "{{ route('curator.submissions.index') }}");
                            }
                        });
                    }
                });

            });
        </script>
    @stop
