<div class="card">
    <div class="card-header p-2">
        <div class="row">
            <div class="col-6">
                <h3 class="text-bold">{{$title}}</h3>
            </div>
            <div class="col-6 text-right">
                <div class="form-group">
                    <h2>Total: {{ $user->getTotalPayment($transactionType) }}</h2>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        {{-- Setup data for datatables --}}
        @php
            $heads = ['Type', 'Status', 'Amount', 'Date'];
            $config = [
                'data' => $transactions,
                'order' => [[1, 'asc']],
                'columns' => [null, null, null, ['orderable' => false]],
            ];
        @endphp

        {{-- Minimal example / fill data using the component slot --}}
        <x-adminlte-datatable id="table{{$tableNumber}}" :heads="$heads">
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
