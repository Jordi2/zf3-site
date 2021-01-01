<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application\Controller;

use Detail\Model\ExercisesTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private $table;
    
    public function __construct(ExercisesTable $table)
    {
        $this->table = $table;
    }
    
    public function indexAction()
    {
        
        try {
            $exercise1 = $this->table->getExercise(1);
            $exercise2 = $this->table->getExercise(18);
            $exercise3 = $this->table->getExercise(54);
        } catch (\Exception $e) {
            die('error');
           // return $this->redirect()->toRoute('application', ['action' => 'index']);
        }
        
        return new ViewModel([
            'exercise1' => $exercise1,
            'exercise2' => $exercise2,
            'exercise3' => $exercise3
        ]);
    }
}
