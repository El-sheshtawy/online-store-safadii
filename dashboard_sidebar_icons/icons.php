<?php

return  [
    [
        'icon' => 'nav-icon fas fa-tachometer-alt',
        'route' => 'admin.dashboard',
        'title' => 'Dashboard',
        'active' => 'dashboard',
    ],

    [
        'icon' => 'fas fa-circle nav-icon',
        'route' => 'admin.categories.index',
        'title' => 'Categories',
        'badge' => 'New',
        'active' => 'dashboard.categories.*',
        'ability' => 'categories.view',
    ],

    [
        'icon' => 'fas fa-circle nav-icon',
        'route' => 'admin.products.index',
        'title' => 'Products',
        'active' => 'dashboard.products.*',
        'ability' => 'products.view' ,
    ],

    [
        'icon' => 'fas fa-circle nav-icon',
        'route' => 'admin.categories.index', // orders.index still not created
        'title' => 'Orders',
        'active' => 'dashboard.orders.*',
        'ability' => 'orders.view' ,
    ],

    [
        'icon' => 'fas fa-circle nav-icon',
        'route' => 'admin.roles.index',
        'title' => 'Roles',
        'active' => 'dashboard.roles.*',
        'ability' => 'roles.view' ,
    ],

    [
        'icon' => 'fas fa-users nav-icon',
        'route' => 'admin.admins.index',
        'title' => 'Admins',
        'active' => 'dashboard.admins.*',
        'ability' => 'admins.view' ,
    ],

];
