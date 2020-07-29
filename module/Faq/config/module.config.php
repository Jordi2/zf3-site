<?php

namespace Faq;

use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'controllers' => [
        'factories' => [
            Controller\FaqController::class => InvokableFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            'faq' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/faq[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\FaqController::class,
                        'action'     => 'faq',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'faq' => __DIR__ . '/../view',
        ],
    ],
];
