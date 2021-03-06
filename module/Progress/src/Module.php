<?php

namespace Progress;

use Detail\Model\Exercises;
use Detail\Model\ExercisesTable;
use Detail\Model\ExercisesTableGateway;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\ResultSet\ResultSet;
use Laminas\Db\TableGateway\TableGateway;
use Laminas\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }
    
    public function getServiceConfig()
    {
        return [
            'factories' => [
                ExercisesTable::class => function($container) {
                    $tableGateway = $container->get(ExercisesTableGateway::class);
                    return new Model\ExercisesTable($tableGateway);
                },
                ExercisesTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Exercises());
                    return new TableGateway('exercises', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }
    
    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\ProgressController::class => function($container) {
                    return new Controller\ProgressController(
                        $container->get(ExercisesTable::class)
                    );
                },
            ],
        ];
    }
}