<div>
    <div class="row">
        {{-- Date Range --}}
        <div class="col-10 d-flex align-items-end" wire:ignore>
            <div class="w-100">
                <x-adminlte-date-range name="drPlaceholder" placeholder="Select a date range..." label="Select a date range">
                    <x-slot name="prependSlot">
                        <div class="input-group-text bg-gradient-danger">
                            <i class="far fa-lg fa-calendar-alt"></i>
                        </div>
                    </x-slot>
                </x-adminlte-date-range>
            </div>
        </div>

        {{-- Clear Button --}}
        <div class="col-2 d-flex align-items-end">
            <div class="form-group">
                <button class="btn btn-secondary h-auto" onclick="window.location.reload()">Clear</button>
            </div>
        </div>
        
    </div>

    <table id="transactionTable" class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Transaction Type</th>
                <th>Amount</th>
                <th>Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $transaction)
                <tr>
                    <td>{{ $transaction->id }}</td>
                    <td>{{ $transaction->user->name ?? 'Unknown User' }}</td>

                    @if ($transaction->type == 'music-payment')
                        <td>paid to website to add a song</td>
                    @elseif ($transaction->type == 'invitation-payment')
                        <td>payment to curator {{ $transaction->offer->user->name ?? 'Unknown offer' }}</td>
                    @else
                        <td>withdrawal request</td>
                    @endif

                    <td>{{ number_format($transaction->amount, 2) }}</td>
                    <td>{{ $transaction->created_at->format('m-d-Y') }}</td>
                </tr>

            @empty
                <tr>
                    <td colspan="5">No transactions found.</td>
                </tr>
            @endforelse
            <tr>
                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                <td colspan="2" class="text-bold text-danger">
                    {{ number_format($totalAmount, 2) }}
                </td>
            </tr>
        </tbody>
    </table>
    <div class="mt-3" id="paginationControls" class="d-flex justify-content-center"></div>



</div>
@push('js')
    <script>
        //date range
        $(function() {
            const input = $('input[name="drPlaceholder"]');
            input.daterangepicker();

            input.on('apply.daterangepicker', function(ev, picker) {
                const range = picker.startDate.format('YYYY-MM-DD') + ' - ' + picker.endDate.format('YYYY-MM-DD');
                @this.set('dateRange', range);
            });
        });

        //pagination function
        document.addEventListener('DOMContentLoaded', () => {
            const table = document.getElementById('transactionTable');
            const rows = [...table.querySelectorAll('tbody tr')].slice(0, -1);
            const totalRow = table.querySelector('tbody tr:last-child');
            const perPage = 10;
            let page = 1;

            const render = () => {
                rows.forEach((row, i) => row.style.display = (i >= (page - 1) * perPage && i < page * perPage) ? '' : 'none');
                totalRow.style.display = '';
                renderPagination();
            };

            const renderPagination = () => {
                const total = Math.ceil(rows.length / perPage);
                const pag = document.getElementById('paginationControls');
                pag.innerHTML = '';
                for (let i = 1; i <= total; i++) {
                    pag.innerHTML += `<button class="btn btn-sm mx-1 ${i===page?'btn-primary':'btn-outline-primary'}" onclick="changePage(${i})">${i}</button>`;
                }
            };

            window.changePage = (num) => {
                page = num;
                render();
            };

            render();
        });

        
    </script>
@endpush
