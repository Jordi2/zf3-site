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
            'detail' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/index[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
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
            'detail' => __DIR__ . '/../view',
        ],
    ],
];
