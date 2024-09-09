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

    'title' => '',
    'title_prefix' => 'Bonica :: ',
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
    | Logo
    |--------------------------------------------------------------------------
    |
    | Here you can change the logo of your admin panel.
    |
    | For detailed instructions you can look the logo section here:
    | https://github.com/jeroennoten/Laravel-AdminLTE/wiki/Basic-Configuration
    |
    */

    'logo' => '<b>Bonica</b>Admin',
    // 'logo_img' => 'vendor/adminlte/dist/img/AdminLTELogo.png',
    'logo_img' => 'favicons/logo.jpeg',
    'logo_img_class' => 'brand-image img-circle elevation-3',
    'logo_img_xl' => null,
    'logo_img_xl_class' => 'brand-image-xs',
    'logo_img_alt' => 'BonicaAdmin',

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
    'usermenu_header' => true,
    'usermenu_header_class' => 'bg-primary',
    'usermenu_image' => true,
    'usermenu_desc' => true,
    'usermenu_profile_url' => true,

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
    'layout_fixed_sidebar' => true,
    'layout_fixed_navbar' => true,
    'layout_fixed_footer' => true,
    'layout_dark_mode' => true,

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
    'classes_sidebar' => 'sidebar-dark-primary elevation-4',
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
    'sidebar_collapse' => true,
    'sidebar_collapse_auto_size' => false,
    'sidebar_collapse_remember' => true,
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

    'right_sidebar' => true,
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
    'dashboard_url' => 'admin',
    'logout_url' => 'logout',
    'login_url' => 'login',
    'register_url' => 'register',
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

    //menu sidebar-menu-search fix bug => https://github.com/jeroennoten/Laravel-AdminLTE/issues/900
    'menu' => [
        // Navbar items:
        [
            'type'         => 'navbar-search',
            'text'         => 'Buscar...',
            'topnav' => true,
        ],
        [
            'type'         => 'fullscreen-widget',
            'topnav_right' => true,
        ],
        [
            'type' => 'sidebar-menu-search',
            'text' => 'Buscar en Menú...',
        ],
        [
            'text' => 'Inicio',
            'route' => 'home',
            'icon' => 'fas fa-fw fa-home',
        ],

        ['header' => 'TAREAS', 'icon' => 'fas fa-cogs'],
        [
            'text' => 'Reservas',
            'icon' => 'fas fa-calendar',
            'submenu' => [
                // [
                //     'text' => 'Reservas Calendario',
                //     'route' => 'admin.calendario.colaboradores.index',
                //     'can' => 'admin.calendario.colaboradores',
                //     'icon' => 'fas fa-calendar',
                    
                // ],
                [
                    'text' => 'Reservas Calendario',
                    'route' => 'admin.rescar.index',
                    'can' => 'admin.calendario.colaboradores',
                    'icon' => 'fas fa-list',
                ],
                [
                    'text' => 'Reservas Lista',
                    'route' => 'admin.lista_reserva.index',
                    'can' => 'admin.calendario.colaboradores',
                    'icon' => 'fas fa-list',
                ],
               
            ],
            

        ],
        [
            'text' => 'Cuentas',
            // 'route' => 'admin.cuentas.index',
            'route' => 'admin.new_cuentas.index',

            'icon' => 'fa fa-shopping-bag',
            'can' => 'admin.cuentas.index'
        ],
        [
            'text' => 'Agregar Clientes',
            'route' => 'admin.personas.index',
            'icon' => 'fas fa-users',
            'can' => 'admin.personas.index'
        ],
        [
            'text' => 'Cumpleaños',
            'route' => 'admin.recordatorios.cumple',
            'icon' => 'fas fa-birthday-cake',
        ],
        ['header' => 'GESTION', 'icon' => 'fas fa-cogs'],
        [
            'text' => 'Reportes',
            'icon' => 'fa fa-file',
            'submenu' => [
                [
                    'text' => 'Reporte Comisiones',
                    'route' => 'admin.comiciones.index',
                    'icon' => 'fas fa-user-cog',
                    'can' => 'admin.gastos.index'
                ],
                [
                    'text' => 'Reporte Preferencias',
                    'route' => 'admin.preferencias.index',
                    'icon' => 'fas fa-user-cog',
                ],
            ],

        ],
        [
            'text' => 'Gestion de insumos',
            'icon' => 'fa fa-file',
            'submenu' => [
                [
                    'text' => 'Insumos',
                    'icon' => 'fas fa-tools',
                    'route' => 'admin.insumos.index',
                    'can' => 'admin.insumos.index'//midlle
                ],
                [
                    'text' => 'Ordenes de insumo',
                    'route' => 'admin.ordinsus.index',
                    'icon' => 'fas fa-random',
                    'can' => 'admin.ordinsus.index'
                ],
                [
                    'text' => 'Transferencias',
                    'route' => 'admin.transfer.index',
                    'icon' => 'fas fa-exchange-alt',
                    'can' => 'admin.transfer.index'
                ],
                [
                    'text' => 'Existencias',
                    'route' => 'admin.existencia.index',
                    'icon' => 'fas fa-store',
                    'can' => 'admin.existencia.index'
                ],
            ],

        ],
        [
            'text' => 'Manejo y Gestion',
            'icon' => 'fa fa-file',
            'submenu' => [
                [
                    'text' => 'Pagar Comisiones Colaboradores',
                    'route' => 'admin.pagos.comisiones.index',
                    'icon' => 'fas fa-user-cog',
                    'can' => 'admin.pagos.comisiones.index'
                ],
                [
                    'text' => 'Pagar Comisiones Afiliados',
                    'route' => 'admin.pagos.comisiones.index',
                    'icon' => 'fas fa-user-cog',
                    'can' => 'admin.pagos.comisiones.index'
                ],
            ],

        ],
        [
            'text' => 'Finanzas',
            'icon' => 'fas fa-hand-holding-usd',
            'submenu' => [
                [
                    'text' => 'Bancos',
                    'route' => 'admin.bancos.index',
                    'icon' => 'fas fa-landmark',
                    'can' => 'admin.insumos.index'//prestado
                ],
                [
                    'text' => 'Cuentas Bancarias',
                    'route' => 'admin.cuentas_bancarias.index',
                    'icon' => 'fas fa-piggy-bank',
                    'can' => 'admin.insumos.index'//prestado
                ],
            ],

        ],
        [
            'text' => 'Ventas',
            'icon' => 'fa fa-shopping-bag',
            'submenu' => [
                [
                    'text' => 'Vender',
                    'route' => 'admin.ventaaas.index',
                    'icon' => 'fa fa-shopping-bag',
                    'can' => 'admin.ventaaas.index'
                ],
                // [
                //     'text' => 'Ventas Pruebas Analia',
                //     'route' => 'admin.ventaaas.index',
                //     'icon' => 'fa fa-shopping-bag',
                //     'can' => 'admin.vender.index'
                // ],
                [
                    'text' => 'Comisiones',
                    'route' => 'admin.comiciones.index',
                    'icon' => 'fa fa-shopping-bag',
                    'can' => 'admin.comiciones.index'
                ],
                [
                    'text' => 'Listado de Ventas',
                    'route' => 'admin.impresion.ventas.index',
                    'icon' => 'fas fa-list',
                    'can' => 'admin.listado.ventas.index'
                ],
                [
                    'text' => ' Anular Ventas',
                    'route' => 'admin.anular.ventas.index',
                    'icon' => 'fa fa-shopping-bag',
                    'can' => 'admin.anular.ventas.index'
                ],
                [
                    'text' => 'Gifcard',
                    'route' => 'admin.giftcard.index',
                    'icon' => 'fa fa-shopping-bag',
                    'can' => 'admin.giftcard.index'
                ],
            ],

        ],
        [
            'text' => 'Compras',
            'icon' => 'fa fa-shopping-bag',
            'submenu' => [
                [
                    'text' => 'Comprar',
                    'route' => 'admin.compras.index',
                    'icon' => 'fas fa-user-cog',
                    'can' => 'admin.compras.index'
                ],
                [
                    'text' => 'Gastos',
                    'route' => 'admin.gastos.index',
                    'icon' => 'fa fa-shopping-bag',
                    'can' => 'admin.gastos.index'
                ],
            ],

        ],
        [
            'text' => 'Accesos',
            'icon' => 'fas fa-lock',
            'submenu' => [
                [
                    'text' => 'Usuarios',
                    'route' => 'admin.users.index',
                    'icon' => 'fas fa-users',
                    'can' => 'admin.users.index'
                ],
                [
                    'text' => 'Roles',
                    'route' => 'admin.roles.index',
                    'icon' => 'fas fa-user-cog',
                    'can' => 'admin.roles.index'
                ],
            ],

        ],


        [
            'text' => 'Mantenimientos',
            'icon' => 'fas fa-cog',
            'submenu' => [
                [
                    'text' => 'Timbrados',
                    'route' => 'admin.timbrados.index',
                    'icon' => '<i class="fas fa-file-invoice"></i>',
                    'can' => 'admin.timbrados.index'
                ],
                [
                    'text' => 'Entidades',
                    'route' => 'admin.entidades.index',
                    'icon' => 'fas fa-building',
                    'can' => 'admin.entidades.index'
                ],
                [
                    'text' => 'Sucursales',
                    'route' => 'admin.sucursales.index',
                    'icon' => 'fas fa-store',
                    'can' => 'admin.sucursales.index'
                ],
                [
                    'text' => 'Comisiones',
                    'route' => 'admin.comisiones.config',
                    'icon' => 'fas fa-users',
                    'can' => 'admin.comisiones.config'
                ],
                [
                    'text' => 'Descuentos',
                    'route' => 'admin.descuentos.index',
                    'icon' => 'fas fa-user-cog',
                    'can' => 'admin.descuentos.index'
                ],
                [
                    'text' => 'Dias Libres',
                    'route' => 'admin.diaslibres.index',
                    'icon' => 'fas fa-user-cog',
                    'can' => 'admin.diaslibres.index'
                    
                ],
            ],

        ],


        [
            'text' => 'Productos y Servicios',
            'icon' => 'fas fa-hand-holding-usd',
            'submenu' => [
                [
                    'text' => 'Categorías de Productos',
                    'icon' => 'fas fa-list',
                    'route' => 'admin.categorias_productos.index',
                    'can' => 'admin.categorias_productos.index'
                ],
                [
                    'text' => 'Categorías de Servicios',
                    'icon' => 'fas fa-list-ul',
                    'route' => 'admin.categorias_servicios.index',
                    'can' => 'admin.categorias_servicios.index'
                ],
                [
                    'text' => 'Productos',
                    'icon' => 'fas fa-boxes',
                    'route' => 'admin.productos.index',
                    'can' => 'admin.productos.index'
                ],
                [
                    'text' => 'Inventarios',
                    'icon' => 'fas fa-boxes',
                    'route' => 'admin.inventarios.index',
                    'can' => 'admin.inventarios.index'
                ],
                [
                    'text' => 'Servicios',
                    'icon' => 'fas fa-concierge-bell',
                    'route' => 'admin.servicios.index',
                    'can' => 'admin.servicios.index'
                ],
                [
                    'text' => 'Combos',
                    'icon' => 'fas fa-shopping-cart',
                    'route' => 'admin.combos.index',
                    'can' => 'admin.combos.index'
                ],
                [
                    'text' => 'Promos',
                    'icon' => 'fas fa-tags',
                    'route' => 'admin.promos.index',
                    'can' => 'admin.promos.index'
                ],
            ],

        ],
        [
            'text' => 'CuentasTwo',
            'route' => 'admin.new_cuentas.index',
            'icon' => 'fa fa-shopping-bag',
            'can' => 'admin.cuentas.index'
        ],
        [
            'text' => 'Ranking e Historial',
            'icon' => 'fas fa-hand-holding-usd',
            'submenu' => [
                [
                    'text' => 'Rank Clientes',
                    'icon' => 'fas fa-chart-line',
                    'route' => 'admin.reporte.ranking.clientes',
                ],
                 [
                    'text' => 'Historial Clientes',
                    'icon' => 'far fa-clock',
                    'route' => 'admin.reporte.historial.clientes',
                ],
                [
                    'text' => 'Clientes dias sin Venir',
                    'icon' => 'far fa-clock',
                    'route' => 'admin.reporte.dias.venir.clientes',
                ],
                [
                    'text' => 'Citas Canceladas',
                    'icon' => 'fa fa-times',
                    'route' => 'admin.reporte.clientes.cc',
                ],
                [
                    'text' => 'Rank Profesionales',
                    'icon' => 'fas fa-chart-line',
                    'route' => 'admin.reporte.rankingprofesionales',
                ],
                [
                    'text' => 'Historial Profesionales',
                    'icon' => 'far fa-clock',
                    'route' => 'admin.reporte.historial.profesionales',
                ],
                [
                    'text' => 'Rank Servicios',
                    'icon' => 'fas fa-chart-line',
                    'route' => 'admin.reporte.ranking.servicios',
                ],
                [
                    'text' => 'Historial Servicios',
                    'icon' => 'far fa-clock',
                    'route' => 'admin.reporte.historial.servicios',
                ],
                [
                    'text' => 'Rank Insumos',
                    'icon' => 'fas fa-chart-line',
                    'route' => 'admin.reporte.rankin.insumo',
                ],
                [
                    'text' => 'Historial Insumos',
                    'icon' => 'far fa-clock',
                    'route' => 'admin.reporte.historial.insumos',
                ],
            ],

        ],


        // ['header' => 'account_settings'],
        // [
        //     'text' => 'profile',
        //     'url'  => 'admin/settings',
        //     'icon' => 'fas fa-fw fa-user',
        // ],
        // [
        //     'text' => 'change_password',
        //     'url'  => 'admin/settings',
        //     'icon' => 'fas fa-fw fa-lock',
        // ],
        // [
        //     'text'    => 'multilevel',
        //     'icon'    => 'fas fa-fw fa-share',
        //     'submenu' => [
        //         [
        //             'text' => 'level_one',
        //             'url'  => '#',
        //         ],
        //         [
        //             'text'    => 'level_one',
        //             'url'     => '#',
        //             'submenu' => [
        //                 [
        //                     'text' => 'level_two',
        //                     'url'  => '#',
        //                 ],
        //                 [
        //                     'text'    => 'level_two',
        //                     'url'     => '#',
        //                     'submenu' => [
        //                         [
        //                             'text' => 'level_three',
        //                             'url'  => '#',
        //                         ],
        //                         [
        //                             'text' => 'level_three',
        //                             'url'  => '#',
        //                         ],
        //                     ],
        //                 ],
        //             ],
        //         ],
        //         [
        //             'text' => 'level_one',
        //             'url'  => '#',
        //         ],
        //     ],
        // ],
        // ['header' => 'labels'],
        // [
        //     'text'       => 'important',
        //     'icon_color' => 'red',
        //     'url'        => '#',
        // ],
        // [
        //     'text'       => 'warning',
        //     'icon_color' => 'yellow',
        //     'url'        => '#',
        // ],
        // [
        //     'text'       => 'information',
        //     'icon_color' => 'cyan',
        //     'url'        => '#',
        // ],
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
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/jquery.dataTables.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables/js/dataTables.bootstrap4.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/responsive/js/dataTables.responsive.js',
                ],

                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.datatables.net/buttons/2.0.0/js/dataTables.buttons.min.js',
                ],
                [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js',
                ], [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js',
                ], [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js',
                ], [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.datatables.net/buttons/2.0.0/js/buttons.html5.min.js',
                ], [
                    'type' => 'js',
                    'asset' => false,
                    'location' => 'https://cdn.datatables.net/buttons/2.0.0/js/buttons.print.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => false,
                    'location' => 'https://cdn.datatables.net/buttons/2.0.0/css/buttons.dataTables.min.css',
                ],

                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables/css/dataTables.bootstrap4.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/datatables-plugins/responsive/css/responsive.bootstrap4.min.css',
                ],

            ],
        ],

        'Select2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/select2/css/select2.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/select2/js/select2.min.js',
                ],
            ],
        ],
        // 'Excel' => [
        //     'active' => true,
        //     'files' => [
        //         [
        //             'type' => 'css',
        //             'asset' => true,
        //             'location' => 'vendor/maatwebsite/excel/select2.css',
        //         ],
        //         [
        //             'type' => 'js',
        //             'asset' => true,
        //             'location' => 'vendor/select2/js/select2.min.js',
        //         ],
        //     ],
        // ],
        // 'FPDF' => [
        //     'active' => true,
        //     'files' => [
        //         [
        //             'type' => 'css',
        //             'asset' => true,
        //             'location' => 'vendor/codedge/src/Fpdf/fpdf.css',
        //         ],
        //         // [
        //         //     'type' => 'js',
        //         //     'asset' => true,
        //         //     'location' => 'vendor/codedge/js/select2.min.js',
        //         // ],
        //     ],
        // ],
        'Chartjs' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    // 'location' => '//cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.0/Chart.bundle.min.js',
                    'location' => 'vendor/chart.js/Chart.bundle.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/chart.js/Chart.min.css',
                ],
            ],

        ],
        'Sweetalert2' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/sweetalert2/sweetalert2.all.min.js',
                ],
            ],
        ],
        'ToastR' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/toastr/toastr.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/toastr/toastr.min.css',
                ],
            ],
        ],
        'FullCalendar' => [
            'active' => true,
            'files' => [
                // [
                //     'type' => 'js',
                //     'asset' => true,
                //     'location' => 'vendor/fullcalendar/-all.min.js',
                // ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/fullcalendar/main.min.js',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/fullcalendar/main.min.css',
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

        'jQueryUI' => [
            'active' => true,
            'files' => [
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/jquery-ui/jquery-ui.theme.min.css',
                ],
                [
                    'type' => 'css',
                    'asset' => true,
                    'location' => 'vendor/jquery-ui/jquery-ui.min.css',
                ],
                [
                    'type' => 'js',
                    'asset' => true,
                    'location' => 'vendor/jquery-ui/jquery-ui.min.js',
                ],
            ],
        ]

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

    'livewire' => true,
];
