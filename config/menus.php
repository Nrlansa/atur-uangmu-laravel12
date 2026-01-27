<?php
return [
    'navMenus' => [
        [
            'label' => 'messages.menu_dashboard',
            'icon'  => 'fa-house',
            'route' => 'dashboard',
            'active' => 'dashboard',
        ],
        [
            'label' => 'messages.menu_budgets',
            'icon' => 'fa-wallet',
            'route' => 'budget.index',
            'active' => 'budget.*',
        ],
        [
            'label' => 'messages.menu_history',
            'icon'  => 'fa-history',
            'route' => 'transactions.index',
            'active' => 'transactions.*',
        ],
        [
            'label' => 'messages.menu_WA',
            'icon'  => 'fa-brands fa-whatsapp',
            'route' => 'whatsapp.index',
            'active' => 'whatsapp.*',
        ],
        [
            'label'=> 'messages.menu_report',
            'icon' => 'fa-file',
            'route'=>'report.index',
            'active'=>'report.*',
        ],
      
    ],
];
