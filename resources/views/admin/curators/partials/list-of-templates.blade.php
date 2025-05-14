<div class="card">
    <div class="card-header">
        <h2><strong>Invitation Templates</strong></h2>
    </div>
    <div class="card-body">

        @php
            $heads = ['ID', 'Invitation Title', 'Publication', 'Status', 'Has Secondary'];

            $config = [
                'data1' => $data1,
                'order' => [[1, 'desc']],
                'columns' => [null, null, null, ['orderable' => false]],
            ];
        @endphp

        <x-adminlte-datatable id="table2" :heads="$heads" hoverable>
            @foreach ($config['data1'] as $row)
                <tr>
                    @foreach ($row as $cell)
                        <td>{!! $cell !!}</td>
                    @endforeach
                </tr>
            @endforeach
        </x-adminlte-datatable>
    </div>
</div>
