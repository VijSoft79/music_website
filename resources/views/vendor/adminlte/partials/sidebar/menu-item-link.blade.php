<li @isset($item['id']) id="{{ $item['id'] }}" @endisset class="nav-item">
    <!-- {{ $item['class'] }} -->
    <a class="nav-link {{ $item['class'] }}  @isset($item['shift']) {{ $item['shift'] }} @endisset" href="{{ $item['href'] }}" @isset($item['target']) target="{{ $item['target'] }}" @endisset {!! $item['data-compiled'] ?? '' !!}>

        <i class="{{ $item['icon'] ?? 'far fa-fw fa-circle' }} {{ isset($item['icon_color']) ? 'text-' . $item['icon_color'] : '' }}"></i>

        <p>
            {{ $item['text'] }}
            @if(isset($item['route']) && $item['route'] === 'curator.offers.in.progress' && \App\Models\Offer::hasLateInvitations())
                <i class="fas fa-exclamation-circle text-danger" style="margin-left: 5px;"></i>
            @endif

            @isset($item['label'])
                <span class="badge badge-{{ $item['label_color'] ?? 'primary' }} right">                
                    {{ $item['label'] }}   
                </span>
            @endisset
        </p>
    </a>

</li>
