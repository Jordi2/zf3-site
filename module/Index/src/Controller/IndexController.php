<?php

namespace Index\Controller;

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

        return new ViewModel();
    }
}