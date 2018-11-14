<?php
return [
	'user' => [
	    'add_default_role_on_register' => true,
	    'default_role'                 => 'user',
	    'admin_permission'             => 'browse_admin',
	    'namespace'                    => App\Models\User::class,
	    'redirect'                     => '/admin'
	],
	'controllers' => [
	    'namespace' => 'TCG\\Voyager\\Http\\Controllers',
	],
	'models' => [
	    'namespace' => 'App\\Models\\',
	],
	'assets_path' => '/vendor/tcg/voyager/assets',
	'storage' => [
	    'disk' => 'public',
	],
	'database' => [
	    'tables' => [
	        'hidden' => ['migrations', 'data_rows', 'data_types', 'menu_items', 'password_resets', 'permission_role', 'settings'],
	    ],
	],
	'prefix' => 'admin',
	'multilingual' => [
	    'enabled' => false,
	    'default' => 'en',
	    'locales' => [
	        'en',
	        //'pt',
	    ],
	],
	'dashboard' => [
	    'navbar_items' => [
	        'Profile' => [
	            'route'         => 'voyager.profile',
	            'classes'       => 'class-full-of-rum',
	            'icon_class'    => 'voyager-person',
	        ],
	        'Home' => [
	            'route'         => '/',
	            'icon_class'    => 'voyager-home',
	            'target_blank'  => true,
	        ],
	        'Logout' => [
	            'route'      => 'voyager.logout',
	            'icon_class' => 'voyager-power',
	        ],
	    ],
	    'widgets' => [
	        'TCG\\Voyager\\Widgets\\UserDimmer',
	        'TCG\\Voyager\\Widgets\\PostDimmer',
	        'TCG\\Voyager\\Widgets\\PageDimmer',
	    ],
	],
	'primary_color' => '#22A7F0',
];