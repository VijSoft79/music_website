@foreach ($musicStatusMessages as $statusMessage)
    @php
        $status = $statusMessage['status'];
        $message = $statusMessage['message'];
        $musicId = $statusMessage['music_id'];
        $offersCount = $statusMessage['offers_count'];

    @endphp
  
    @if ($status == 'pending')
        <x-adminlte-alert id="permanentMessage{{ $musicId }}" theme="success" title="Submitted">
            {!! $message !!}
        </x-adminlte-alert>
    @elseif($status == 'unpaid')
        <x-adminlte-alert theme="warning" title="Unpaid">
            {!! $message !!}
            
        </x-adminlte-alert>
    @elseif($status == 'approve' && $offersCount == 0)
        <x-adminlte-alert theme="info" title="Approved" icon="fa fa-lg fa-thumbs-up" >
            {!! $message !!}
        </x-adminlte-alert>
        
    @endif
@endforeach
