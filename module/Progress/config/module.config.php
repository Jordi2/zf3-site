<?php

namespace Progress;

use Laminas\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'progress' => [
                'type'    => Segment::class,
                'options' => [
                    'route' => '/progress[/:action]',
                    'constraints' => [
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ],
                    'defaults' => [
                        'controller' => Controller\ProgressController::class,
                        'action'     => 'progress',
                    ],
                ],
            ],
        ],
    ],
    'view_manager' => [
        'template_path_stack' => [
            'progress' => __DIR__ . '/../view',
        ],
    ],
];
