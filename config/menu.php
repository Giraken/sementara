<?php

return [
    [
        'title' => 'menu',
        'menu' => [
            [
                'title' => 'dashboard',
                'icon' => 'ri-dashboard-line',
                'route' => 'dashboard',
            ], [
                'id' => 'apps',
                'title' => 'apps',
                'icon' => 'ri-apps-line',
                'route' => 'apps.my',
                //                "submenu" => [
                //                    [
                //                        "title" => "apps.add",
                //                        "route" => 'store',
                //                    ],[
                //                        "title" => "apps.my",
                //                        "route" => "apps.my",
                //                    ],
                //                ]
            ],
            [
                'id' => 'teams',
                'title' => 'teams',
                'icon' => 'ri-group-2-line',
                'route' => 'teams.my',
                //                "submenu" => [
                //                    [
                //                        "title" => "create_new",
                //                        "route" => 'teams.create',
                //                    ],[
                //                        "title" => "list",
                //                        "route" => 'teams.my',
                //                    ],
                //                ]
            ],
        ],
    ], [
        'title' => 'account',
        'menu' => [
            [
                'title' => 'billing',
                'icon' => 'ri-bank-card-2-line',
                'route' => 'account.billing',
            ], [
                'title' => 'profile',
                'icon' => 'ri-account-circle-line',
                'route' => 'account.profile',
            ],
        ],
    ],
];
