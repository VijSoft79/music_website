<div class="container-fluid" style="font-size:20px">
    @if (Auth::user()->is_approve == 0)
        @if (Auth::user()->location && Auth::user()->genre && Auth::user()->bio)
            <x-adminlte-alert class="bg-teal " icon="fa fa-lg fa-thumbs-up" title="Done">
                {!! $userStatusMessage !!}
            </x-adminlte-alert>
        @else
            <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">close</button>
                <h5>
                    <i class="icon fas fa-exclamation-triangle"></i>
                    Pending Approval!
                </h5>
                {!! $userStatusMessage !!}
            </div>
        @endif

    @else
    
        @if (Auth::user()->location && Auth::user()->genre && Auth::user()->bio)
            <x-adminlte-alert class="bg-teal " icon="fa fa-lg fa-thumbs-up" title="Done">
                {!! $userStatusMessage !!}
            </x-adminlte-alert>
        @else
            <div class="alert alert-success alert-dismissible">
                <h5>
                    <i class="icon fas fa-exclamation-triangle"></i>
                    Approve!
                </h5>
                {!! $userStatusMessage !!}
            </div>
        @endif
    @endif
</div>