<?php

namespace Index;

use Laminas\Router\Http\Segment;

return [
    /*'controllers' => [
        'factories' => [
            Controller\DetailController::class => InvokableFactory::class,
        ],
    ],*/
    'router' => [
        'routes' => [
            'index' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/index[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'index' => __DIR__ . '/../view',
        ],
    ],
];
