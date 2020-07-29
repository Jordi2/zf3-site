<?php

namespace Search;

use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\SearchController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'search' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/search[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\SearchController::class,
                        'action'     => 'search',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'search' => __DIR__ . '/../view',
        ],
    ],
];
