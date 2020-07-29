<?php

namespace Detail;

use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\DetailController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'detail' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/detail[/:action[/:id]]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ],
                    'defaults' => [
                        'controller' => Controller\DetailController::class,
                        'action'     => 'detail',
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
