@php($logout_url = View::getSection('logout_url') ?? config('adminlte.logout_url', 'logout'))

@if (config('adminlte.use_route_url', false))
    @php($logout_url = $logout_url ? route($logout_url) : '')
@else
    @php($logout_url = $logout_url ? url($logout_url) : '')
@endif

<li class="nav-item">
    <a class="nav-link" href="#" onclick="handleLogout(event)">
        <i class="fa fa-fw fa-power-off text-red"></i>
        {{ __('adminlte::adminlte.log_out') }}
    </a>
    <form id="logout-form" action="{{ $logout_url }}" method="POST" style="display: none;">
        @if (config('adminlte.logout_method'))
            {{ method_field(config('adminlte.logout_method')) }}
        @endif
        {{ csrf_field() }}
    </form>
</li>


@push('js')
    <script>
        //this function prevents error 419 if logout
        //conflict with chat notification which expires the csrf token
        function handleLogout(event) {
            event.preventDefault();

            if (window.Livewire) {
                Livewire.stopPolling = () => {
                    Livewire.components.forEach(component => {
                        if (component.__livewire_polling_interval) {
                            clearInterval(component.__livewire_polling_interval);
                        }
                    });
                };
                Livewire.stopPolling();
            }

            setTimeout(() => {
                document.getElementById('logout-form').submit();
            }, 100);
        }
    </script>
@endpush
