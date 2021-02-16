<?php

namespace Progress\Controller;

use Detail\Model\ExercisesTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class ProgressController extends AbstractActionController
{
    private $table;
    
    public function __construct(ExercisesTable $table)
    {
        $this->table = $table;
    }
    
    public function indexAction() 
    {
        return $this->redirect()->toRoute('progress', ['action' => 'progress']);
    }
    
    public function progressAction()
    {
        $classificationTypes = $this->table->getAllClassifications()->toArray();
        $tagTypes = $this->table->getAllTags()->toArray();
        
        $classifications = null;
        $tags = null;
        $showVariations = false;

        // Check which filters are active
        
        for($i = 0; $i < count($classificationTypes); $i++) {
            if (isset($_GET['classification'.$classificationTypes[$i]['id']])) {
                if($classifications === null)
                    $classifications = $_GET['classification'.$classificationTypes[$i]['id']];
                else 
                    $classifications .= ', '. $_GET['classification'.$classificationTypes[$i]['id']];
                
                $classificationTypes[$i]['checked'] = 'checked';
            }
            else
                $classificationTypes[$i]['checked'] = '';
        };
        
        for($i = 0; $i < count($tagTypes); $i++) {
            if (isset($_GET['tag'.$tagTypes[$i]['id']])) {
                if($tags === null)
                    $tags = $_GET['tag'.$tagTypes[$i]['id']];
                else 
                    $tags .= ', '. $_GET['tag'.$tagTypes[$i]['id']];
                
                $tagTypes[$i]['checked'] = 'checked';
            }
            else
                $tagTypes[$i]['checked'] = '';
        };
       
        if (isset($_GET['variation'])) 
            $showVariations = true;
        
        try {
            $exerciseProgressions = $this->table->getProgressionTreeByFilter($classifications, $tags, true);
        } catch (\Exception $e) {
            die('error');
           // return $this->redirect()->toRoute('application', ['action' => 'index']);
        }
        
        return new ViewModel([
            'classifications' => $classificationTypes,
            'tags' => $tagTypes,
            'showVariation' => $showVariations ? 'checked' : '',
            'exerciseProgressions' => $exerciseProgressions
        ]);
    }
}