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
    
    public function searchAction()
    {
        $request = $this->getRequest();

        if (! $request->isPost()) {

        }
        else {
            $request->getPost();
        }  
        
        
        //$form = new AlbumForm();
        //$form->get('submit')->setAttribute('value', 'Send');
        try {
            $exercises = $this->table->getAllExercises();
            $classifications = $this->table->getAllClassifications();
            $tags = $this->table->getAllTags();
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }
        return new ViewModel([
            'exercises' => $exercises,
            'classifications' => $classifications,
            'tags' => $tags//,
           // 'form' => $form
        ]);
    }
}