@extends('adminlte::page')

@section('title', 'Admin-Offer-Template-edit')
@section('plugins.Datatables', true)
@section('plugins.DatatablesPlugin', true)


@section('content_header')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <form action="{{ route('admin.templates.update', $OfferTemplate) }}" method="post">
                    @csrf
                    @if ($OfferTemplate->freeAlternative)
                        @include('admin.templates.partials.free-alternatives-form')
                    @elseif($OfferTemplate->spotifyPlayList)
                        @include('admin.templates.partials.spotify-playlist-form')
                    @endif


                    @include('admin.templates.partials.basic-offer-form')

                    @if ($OfferTemplate->has_premium == 1)
                        @include('admin.templates.partials.premium-offer-form')
                    @endif

                    <div class="row">
                        @if ($OfferTemplate->status == 1)
                            <div class="col-2">
                                <button type="submit" class="btn btn-block btn-outline-danger" name="status" value="2">Disapprove</button>
                            </div>
                        @elseif($OfferTemplate->status == 0)
                            <div class="col-2">
                                <button type="submit" class="btn btn-block btn-outline-primary" name="status" value="1">Approve</button>
                            </div>
                            <div class="col-2">
                                <button type="submit" class="btn btn-block btn-outline-danger" name="status" value="2">Disapprove</button>
                            </div>
                        @endif


                    </div>
                </form>
            </div>
        </div>

        <div class="col-12 mt-4">
            <div class="card">
                <div class="card-header">
                    <h3>Template Offers</h3>
                </div>
                    <div class="card-body">
                        @php
                            $heads = [
                                'ID',
                                'Music Offer',
                                'Status',
                                ['label' => '', 'no-export' => true, 'width' => 5],
                            ];

                            $config = [
                                'data' => $data,
                                'order' => [[1, 'asc']],
                                'columns' => [null, null, null, ['orderable' => false]],
                            ];
                        @endphp

                        <x-adminlte-datatable id="table1" :heads="$heads">
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
@stop


@section('js')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var inputs = document.querySelectorAll('.input');
            inputs.forEach(function(input) {
                input.disabled = true;
            });
        });
    </script>
@stop
