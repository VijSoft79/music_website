<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Title
    |--------------------------------------------------------------------------
    |
    | Here you can change the default title of your admin panel.
    |
    | For detailed instructions you can look the title section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'title' => 'YouHearUs',
    'title_prefix' => '',
    'title_postfix' => '',

    /*
    |--------------------------------------------------------------------------
    | Favicon
    |--------------------------------------------------------------------------
    |
    | Here you can activate the favicon.
    |
    | For detailed instructions you can look the favicon section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_ico_only' => false,
    'use_full_favicon' => true,

    /*
    |--------------------------------------------------------------------------
    | Google Fonts
    |--------------------------------------------------------------------------
    |
    | Here you can allow or not the use of external google fonts. Disabling the
    | google fonts may be useful if your admin panel internet access is
    | restricted somehow.
    |
    | For detailed instructions you can look the google fonts section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'google_fonts' => [
        'allowed' => true,
    ],

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    // 'logo' => '<b>Admin</b>LTE',
    'logo_img' => config('app.url') . '/images/logo.png',
    'logo_img_class' => 'brand-image elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'Admin Logo',

    /*
    |--------------------------------------------------------------------------
    | Authentication Logo
    |--------------------------------------------------------------------------
    |
    | Here you can setup an alternative logo to use on your login and register
    | screens. When disabled, the admin panel logo will be used instead.
    |
    | For detailed instructions you can look the auth logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'auth_logo' => [
        'enabled' => false,
        'img' => [
            'path' => config('app.url') . '/images/logo.png',
            'alt' => 'Auth Logo',
            'class' => '',
            'width' => 50,
            'height' => 50,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Preloader Animation
    |--------------------------------------------------------------------------
    |
    | Here you can change the preloader animation configuration. Currently, two
    | modes are supported: 'fullscreen' for a fullscreen preloader animation
    | and 'cwrapper' to attach the preloader animation into the content-wrapper
    | element and avoid overlapping it with the sidebars and the top navbar.
    |
    | For detailed instructions you can look the preloader section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'preloader' => [
        'enabled' => true,
        'mode' => 'fullscreen',
        'img' => [
            'path' => config('app.url') . '/images/logo.png',
            'alt' => 'AdminLTE Preloader Image',
            'effect' => 'animation__shake',
            'width' => 60,
            'height' => 60,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | User Menu
    |--------------------------------------------------------------------------
    |
    | Here you can activate and change the user menu.
    |
    | For detailed instructions you can look the user menu section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'usermenu_enabled' => true,
    'usermenu_header' => false,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => false,
    'usermenu_desc' => false,
    'usermenu_profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Layout
    |--------------------------------------------------------------------------
    |
    | Here we change the layout of your admin panel.
    |
    | For detailed instructions you can look the layout section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'layout_topnav' => null,
    'layout_boxed' => null,
    'layout_fixed_sidebar' => null,
    'layout_fixed_navbar' => null,
    'layout_fixed_footer' => true,
    'layout_dark_mode' => null,

    /*
    |--------------------------------------------------------------------------
    | Authentication Views Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the authentication views.
    |
    | For detailed instructions you can look the auth classes section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_auth_card' => 'card-outline card-primary',
    'classes_auth_header' => '',
    'classes_auth_body' => '',
    'classes_auth_footer' => '',
    'classes_auth_icon' => '',
    'classes_auth_btn' => 'btn-flat btn-primary',

    /*
    |--------------------------------------------------------------------------
    | Admin Panel Classes
    |--------------------------------------------------------------------------
    |
    | Here you can change the look and behavior of the admin panel.
    |
    | For detailed instructions you can look the admin panel classes here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'classes_body' => '',
    'classes_brand' => '',
    'classes_brand_text' => '',
    'classes_content_wrapper' => '',
    'classes_content_header' => '',
    'classes_content' => '',
    'classes_sidebar' => 'sidebar-light-primary elevation-4',
    'classes_sidebar_nav' => '',
    'classes_topnav' => 'navbar-white navbar-light',
    'classes_topnav_nav' => 'navbar-expand',
    'classes_topnav_container' => 'container',

    /*
    |--------------------------------------------------------------------------
    | Sidebar
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar of the admin panel.
    |
    | For detailed instructions you can look the sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'sidebar_mini' => 'lg',
    'sidebar_collapse' => false,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => false,
    'sidebar_collapse_remember_no_transition' => true,
    'sidebar_scrollbar_theme' => 'os-theme-light',
    'sidebar_scrollbar_auto_hide' => 'l',
    'sidebar_nav_accordion' => true,
    'sidebar_nav_animation_speed' => 300,

    /*
    |--------------------------------------------------------------------------
    | Control Sidebar (Right Sidebar)
    |--------------------------------------------------------------------------
    |
    | Here we can modify the right sidebar aka control sidebar of the admin panel.
    |
    | For detailed instructions you can look the right sidebar section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Layout-and-Styling-Configuration
    |
    */

    'right_sidebar' => false,
    'right_sidebar_icon' => 'fas fa-cogs',
    'right_sidebar_theme' => 'dark',
    'right_sidebar_slide' => true,
    'right_sidebar_push' => true,
    'right_sidebar_scrollbar_theme' => 'os-theme-light',
    'right_sidebar_scrollbar_auto_hide' => 'l',

    /*
    |--------------------------------------------------------------------------
    | URLs
    |--------------------------------------------------------------------------
    |
    | Here we can modify the url settings of the admin panel.
    |
    | For detailed instructions you can look the urls section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'use_route_url' => false,
    'dashboard_url' => 'home',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
    'musician_register_url' => 'musicianRegister',
    'curator_register_url' => 'curatorRegister',
    'password_reset_url' => 'password/reset',
    'password_email_url' => 'password/email',
    'profile_url' => false,

    /*
    |--------------------------------------------------------------------------
    | Laravel Mix
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Laravel Mix option for the admin panel.
    |
    | For detailed instructions you can look the laravel mix section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'enabled_laravel_mix' => false,
    'laravel_mix_css_path' => 'css/app.css',
    'laravel_mix_js_path' => 'js/app.js',

    /*
    |--------------------------------------------------------------------------
    | Menu Items
    |--------------------------------------------------------------------------
    |
    | Here we can modify the sidebar/top navigation of the admin panel.
    |
    | For detailed instructions you can look here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'menu' => [

        [
            'header' => 'account_settings',
        ],
        // admin
        [
            'text' => 'Profile',
            'url' => '/dashboard/profile',
            'icon' => 'fa-solid fa-user',
            'roles' => ['writer'],
        ],
        [
            'text' => 'Dashboard',
            'url' => '/dashboard',
            'icon' => 'fa-solid fa-gauge',
            'roles' => ['administrator'],
        ],
        [
            'header' => 'Users',
            'roles' => ['administrator'],

        ],
        [
            'text' => 'Musician',
            'url' => '/dashboard/musicians',
            'icon' => 'fa-solid fa-user',
            'roles' => ['administrator'],
        ],
        [
            'text' => 'Curators',
            'url' => '/dashboard/curators',
            'icon' => 'fa-solid fa-user',
            'roles' => ['administrator'],
        ],
        [
            'text' => 'Writers',
            'url' => '/dashboard/writers',
            'icon' => 'fa-solid fa-user',
            'roles' => ['administrator'],
        ],
        [
            'header' => 'Music',
            'roles' => ['administrator'],

        ],
        [
            'text' => 'Music',
            'icon' => 'fa-solid fa-music',
            'roles' => ['administrator'],
            'submenu' => [
                [
                    'text' => 'Pending',
                    'url' => '/dashboard/music/pending',
                    'icon' => 'fa-solid fa-hourglass-half'
                ],
                [
                    'text' => 'Unpaid',
                    'url' => '/dashboard/music/unpaid',
                    'icon' => 'fa-solid fa-clipboard-list'
                ],
                [
                    'text' => 'approved',
                    'url' => '/dashboard/music/approve',
                    'icon' => 'fa-solid fa-check-to-slot'
                ],
            ]
        ],
        [
            'text' => 'Genre',
            'url' => 'dashboard/genres',
            'icon' => 'fa-solid fa-list',
            'roles' => ['administrator'],
        ],
        [
            'text' => 'Coupon',
            'url' => 'dashboard/coupon',
            'icon' => 'fa-solid fa-id-card-clip',
            'roles' => ['administrator'],
            'submenu' => [
                [
                    'text' => 'All Coupon',
                    'url' => '/dashboard/coupon/',
                    'icon' => 'fa-regular fa-rectangle-list',
                ],
                [
                    'text' => 'Add Coupon',
                    'url' => '/dashboard/coupon/create',
                    'icon' => 'fa-solid fa-ticket',
                ],
            ],
        ],
        [
            'header' => 'Invitation',
            'roles' => ['administrator'],
        ],
        [
            'text' => 'Invitations',
            'icon' => 'fa-solid fa-users',
            'roles' => ['administrator'],
            'submenu' => [
                [
                    'text' => 'Reports',
                    'url' => '/dashboard/invitation/reports',
                    'icon' => 'fa-solid fa-file-lines',
                ],
                [
                    'text' => 'completed',
                    'url' => '/dashboard/invitation/completed',
                    'icon' => 'fa-solid fa-list-check',
                ],
            ],
        ],
        [
            'text' => 'Invitation Template',
            'url' => 'dashboard/offer-templates',
            'icon' => 'fa-solid fa-table',
            'roles' => ['administrator'],
        ],
        [
            'text' => 'Withdrawal Request',
            'url' => 'dashboard/withdrawal/',
            'icon' => 'fa-solid fa-cash-register',
            'roles' => ['administrator'],
        ],
        [
            'header' => 'Blog Post',
            'roles' => ['administrator'],
        ],
        [
            'text' => 'Blog Post',
            'url' => 'dashboard/blog-post',
            'icon' => 'fa-solid fa-blog',
            'roles' => ['administrator', 'writer'],
            'submenu' => [
                [
                    'text' => 'All Blog',
                    'url' => '/dashboard/blog-post',
                    'icon' => 'fa-brands fa-blogger-b',
                ],
                [
                    'text' => 'Add Blog',
                    'url' => '/dashboard/blog-post/create',
                    'icon' => 'fa-solid fa-right-to-bracket',
                ],
            ],
        ],
        [
            'text' => 'Blog Categories',
            'url' => 'dashboard/categories',
            'icon' => 'fa-solid fa-layer-group',
            'roles' => ['administrator', 'writer']
        ],
        [
            'text' => 'Updates',
            'url' => 'dashboard/updates',
            'icon' => 'fa-solid fa-pen',
            'roles' => ['administrator']
        ],
        [
            'header' => 'Others',
            'roles' => ['administrator'],
        ],
        [
            'text' => 'Emails',
            'url' => 'dashboard/emails',
            'icon' => 'fa-solid fa-envelope',
            'roles' => ['administrator'],
        ],
        [
            'text' => 'Page Content',
            'url' => 'dashboard/page-content',
            'icon' => 'fa-solid fa-newspaper',
            'roles' => ['administrator'],
        ],
        [
            'text' => 'Page Messages',
            'url' => 'dashboard/page-messages',
            'icon' => 'fa-solid fa-envelope-open-text',
            'roles' => ['administrator'],
        ],
        [
            'text' => 'Transactions',
            'url' => 'dashboard/transactions',
            'icon' => 'fa-solid fa-arrow-right-arrow-left',
            'roles' => ['administrator'],
        ],
        [
            'text' => 'Campaigns',
            'url' => 'dashboard/campaigns',
            'icon' => 'fa-solid fa-bullhorn',
            'roles' => ['administrator'],
        ],


        [
            'text' => 'Settings',
            'url' => 'dashboard/adminsetting',
            'icon' => 'fa fa-gear',
            'roles' => ['administrator'],
        ],
        //curator
        [
            'text' => 'Dashboard',
            'route' => 'curator.home',
            'icon' => 'fa fa-flag',
            'roles' => ['curator'],

        ],
        [
            'text' => 'Profile',
            'route' => 'curator.show',
            'icon' => 'fa fa-user',
            'roles' => ['curator'],
        ],
        [
            'text' => 'chats',
            'route' => 'chat.index',
            'icon' => 'fa fa-comment',
            'roles' => ['curator'],
        ],
        [
            'header' => 'Work Settings',
            'roles' => ['curator'],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],
        [
            'text' => 'Artist Submissions',
            'route' => 'curator.submissions.index',
            'icon' => 'fa fa-music',
            'roles' => ['curator'],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1 && \App\Models\OfferTemplate::where('user_id', auth()->id())->where('status', 1)->count() != 0;
            },
        ],
        [
            'header' => 'Invitation Template',
            'roles' => ['curator'],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],
        [
            'text' => 'Invitations',
            'icon' => 'fa-solid fa-users',
            'roles' => ['curator'],
            'submenu' => [
                [
                    'text' => 'Pending',
                    'route' => 'curator.offers.index',
                    'icon' => 'fa-solid fa-hourglass-half',
                    'shift' => 'ml-4',
                ],
                [
                    'text' => 'In Progress',
                    'route' => 'curator.offers.in.progress',
                    'icon' => 'fa-solid fa-clock-rotate-left',
                    'shift' => 'ml-4',
                ],
                [
                    'text' => 'Completed',
                    'url' => '/dashboard/curator/offers/completed',
                    'icon' => 'fa-solid fa-clipboard-check',
                    'shift' => 'ml-4',
                ],
                [
                    'text' => 'Reports',
                    'url' => '/dashboard/curator/offers/reports',
                    'icon' => 'fa-solid fa-file-lines',
                    'shift' => 'ml-4',
                ],
                [
                    'text' => 'Declined',
                    'url' => '/dashboard/curator/offers/declined',
                    'icon' => 'fa-solid fa-file-lines',
                    'shift' => 'ml-4',
                ],
            ],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],
        [
            'text' => 'All Invitation Templates',
            'route' => 'curator.offer.template.index',
            'icon' => 'fa fa-th',
            'roles' => ['curator'],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],
        [
            'text' => 'Add Invitation Template',
            'route' => 'curator.offer.template.create',
            'icon' => 'fa-solid fa-folder-plus',
            'roles' => ['curator'],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],
        [
            'text' => 'Spotify Playlist',
            'route' => 'spotify.login',
            'icon' => 'fa-brands fa-spotify',
            'roles' => ['curator'],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],
        [
            'header' => 'Others',
            'roles' => ['curator'],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],
        [
            'text' => 'Help',
            'url' => '/dashboard/curator/help',
            'icon' => 'fa-solid fa-message',
            'roles' => ['curator'],
        ],
        //musician
        [
            'text' => 'Dashboard',
            'url' => '/dashboard/musician/',
            'icon' => 'fa-solid fa-table-columns',
            'roles' => ['musician'],
        ],
        [
            'text' => 'Profile',
            'url' => '/dashboard/musician/profile',
            'icon' => 'fa-solid fa-user',
            'roles' => ['musician'],
        ],
        [
            'text' => 'chats',
            'route' => 'chat.index',
            'icon' => 'fa fa-comment',
            'roles' => ['musician'],
        ],
        [
            'text' => 'Invitations',
            'icon' => 'fa-solid fa-envelope',
            'roles' => ['musician'],
            'submenu' => [
                [
                    'text' => 'Pending',
                    'url' => '/dashboard/musician/invitations',
                    'icon' => 'fa-solid fa-hourglass-half',
                    'shift' => 'ml-4',
                ],
                [
                    'text' => 'In Progress',
                    'url' => '/dashboard/musician/invitations/in-progress',
                    'icon' => 'fa-solid fa-clock-rotate-left',
                    'shift' => 'ml-4',
                ],
                [
                    'text' => 'completed',
                    'url' => '/dashboard/musician/invitations/completed',
                    'icon' => 'fa-solid fa-clipboard-check',
                    'shift' => 'ml-4',
                ],
            ],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],
        [
            'header' => 'Music',
            'roles' => ['musician'],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],
        [
            'text' => 'All music',
            'url' => '/dashboard/musician/music',
            'icon' => 'fa-solid fa-music',
            'roles' => ['musician'],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],
        [
            'text' => 'Submit music',
            'url' => '/dashboard/musician/music/create',
            'icon' => 'fa-solid fa-share',
            'roles' => ['musician'],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],
        [
            'text' => 'Payment History',
            'url' => '/dashboard/musician/transactions',
            'icon' => 'fa-solid fa-credit-card',
            'roles' => ['musician'],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],
        [
            'text' => 'Help',
            'url' => '/dashboard/musician/help',
            'icon' => 'fa-solid fa-message',
            'roles' => ['musician'],
            'can' => function () {
                return auth()->check() && auth()->user()->is_approve == 1;
            },
        ],


    ],



    /*
    |--------------------------------------------------------------------------
    | Menu Filters
    |--------------------------------------------------------------------------
    |
    | Here we can modify the menu filters of the admin panel.
    |
    | For detailed instructions you can look the menu filters section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Menu-Configuration
    |
    */

    'filters' => [
        JeroenNoten\LaravelAdminLte\Menu\Filters\GateFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\HrefFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\SearchFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ActiveFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\ClassesFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\LangFilter::class,
        JeroenNoten\LaravelAdminLte\Menu\Filters\DataFilter::class,
        App\Filters\UserRoleMenuFilter::class,
    ],

    /*
    |--------------------------------------------------------------------------
    | Plugins Initialization
    |--------------------------------------------------------------------------
    |
    | Here we can modify the plugins used inside the admin panel.
    |
    | For detailed instructions you can look the plugins section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Plugins-Configuration
    |
    */

    'plugins' => [
        'Datatables' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css',
                ],
            ],
        ],
        'TempusDominusBs4' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/moment/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css',
                ],
            ],
        ],
        'DatatablesPlugins' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.html5.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/js/buttons.print.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/jszip/jszip.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/pdfmake.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/pdfmake/vfs_fonts.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/buttons/css/buttons.bootstrap4.min.css',
                ],
            ],
        ],
        'BootstrapSwitch' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bootstrap-switch/js/bootstrap-switch.min.js',
                ],
            ],
        ],
        'Select2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.full.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2-bootstrap4-theme/select2-bootstrap4.min.css',
                ],
            ],
        ],
        'Chartjs' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                ],
            ],
        ],
        'Sweetalert2' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdn.jsdelivr.net/npm/sweetalert2@8',
                ],
            ],
        ],
        'Pace' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/themes/blue/pace-theme-center-radar.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => '//cdnjs.cloudflare.com/ajax/libs/pace/1.0.2/pace.min.js',
                ],
            ],
        ],
        'Summernote' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/summernote/summernote-bs4.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/summernote/summernote-bs4.min.css',
                ],
            ],
        ],
        'BsCustomFileInput' => [
            'active' => false,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/bs-custom-file-input/bs-custom-file-input.min.js',
                ],
            ],
        ],
        'Daterangepicker' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/moment@2.29.4/moment.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/daterangepicker@3.1/daterangepicker.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.jsdelivr.net/npm/daterangepicker@3.1/daterangepicker.css',
                ],
            ],
        ],

    ],

    /*
    |--------------------------------------------------------------------------
    | IFrame
    |--------------------------------------------------------------------------
    |
    | Here we change the IFrame mode configuration. Note these changes will
    | only apply to the view that extends and enable the IFrame mode.
    |
    | For detailed instructions you can look the iframe mode section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/IFrame-Mode-Configuration
    |
    */

    'iframe' => [
        'default_tab' => [
            'url' => null,
            'title' => null,
        ],
        'buttons' => [
            'close' => true,
            'close_all' => true,
            'close_all_other' => true,
            'scroll_left' => true,
            'scroll_right' => true,
            'fullscreen' => true,
        ],
        'options' => [
            'loading_screen' => 1000,
            'auto_show_new_tab' => true,
            'use_navbar_items' => true,
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Livewire
    |--------------------------------------------------------------------------
    |
    | Here we can enable the Livewire support.
    |
    | For detailed instructions you can look the livewire here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Other-Configuration
    |
    */

    'livewire' => false,
];
