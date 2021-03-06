<?php

namespace Search\Controller;

use Detail\Model\ExercisesTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class SearchController extends AbstractActionController
{
    private $table;
    
    public function __construct(ExercisesTable $table)
    {
        $this->table = $table;
    }
    
    public function indexAction() 
    {
        return $this->redirect()->toRoute('search', ['action' => 'search']);
    }
    
    public function searchAction()
    {
        $request = $this->getRequest();

        
        if ( $request->isPost()) {
            $request->getPost();
        }
        

        try {
            $exercises = $this->table->getAllExercisesForSearch('');
            $classifications = $this->table->getAllClassifications();
            $tags = $this->table->getAllTags();
        } catch (\Exception $e) {
            //return $this->redirect()->toRoute('album', ['action' => 'index']);
        }
        return new ViewModel([
            'exercises' => $exercises,
            'classifications' => $classifications,
            'tags' => $tags//,
           // 'form' => $form
        ]);
    }
}