<aside class="main-sidebar {{ config('adminlte.classes_sidebar', 'sidebar-dark-primary elevation-4') }}">

    {{-- Sidebar brand logo --}}
    @if (config('adminlte.logo_img_xl'))
        @include('adminlte::partials.common.brand-logo-xl')
    @else
        @include('adminlte::partials.common.brand-logo-xs')
    @endif
    <style>
        .sidebar{
            font-size:20px;
        }
    </style>

    {{-- Sidebar menu --}}
    <div class="sidebar">
        <nav class="pt-2">
            <ul class="nav nav-pills nav-sidebar flex-column {{ config('adminlte.classes_sidebar_nav', '') }}"
                data-widget="treeview" role="menu"
                @if (config('adminlte.sidebar_nav_animation_speed') != 300) data-animation-speed="{{ config('adminlte.sidebar_nav_animation_speed') }}" @endif
                @if (!config('adminlte.sidebar_nav_accordion')) data-accordion="false" @endif>
                {{-- Configured sidebar links --}}
                {{-- @each('adminlte::partials.sidebar.menu-item', $adminlte->menu('sidebar'), 'item') --}}

                <!-- Conditional Navigation Item -->
                {{-- @dd($adminlte->menu('sidebar')) --}}
                {{-- @foreach ($adminlte->menu('sidebar') as $item)
                    @if (in_array('can', $item))
                        @if ($item->text == 'Approve Users' && auth()->check() && auth()->user()->is_approve != 1)
                            @continue
                        @endif

                        @include('adminlte::partials.sidebar.menu-item', ['item' => $item])
                    @endif
                @endforeach --}}

                @foreach ($adminlte->menu('sidebar') as $item)
                    @php
                        $canDisplay = true;

                        // Check if the item is an array and has a 'can' key
                        if (isset($item['can'])) {
                            $canDisplay = $item['can']();
                        }

                        // Hide 'Artist Submissions' for non-approved users
                        if (
                            isset($item['text']) &&
                            $item['text'] == 'Artist Submissions' &&
                            auth()->check() &&
                            auth()->user()->is_approve != 1
                        ) {
                            $canDisplay = false;
                        }
                    @endphp

                    @if ($canDisplay)
                        @include('adminlte::partials.sidebar.menu-item', ['item' => $item])
                    @endif
                @endforeach

            </ul>
        </nav>
    </div>

</aside>
