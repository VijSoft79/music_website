<div {{ $attributes->merge(['class' => "p-0 col-{$size}"]) }}>

    <span class="">
        {{-- Icon --}}
        @isset($icon)
            <i class="{{ $icon }}"></i>
        @endisset

        {{-- Header --}}
        @isset($title)
            @if(! empty($url))
                <a href="{{ $url }}">{{ $title }}</a>
            @else
                {{ $title }}
            @endif
        @endisset

        {{-- Text --}}
        @isset($text)
            <span class="{{ $makeTextWrapperClass() }}">
                {{ $text }}
            </span>
        @endisset

    </span>

</div>
