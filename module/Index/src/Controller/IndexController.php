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
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('application', ['action' => 'index']);
        }
        
        try {
            $exerciseName = $this->table->getExercise($id);
            $exerciseClassifications = $this->table->getAllClassificationsByExerciseId($id);
            $exerciseTags = $this->table->getAllTagForExerciseId($id);
            $exerciseExamples = $this->table->getExerciseTemp($id);
            $exerciseReadings = $this->table->getAllReadingsForExerciseId($id);
            $exerciseVariations = $this->table->getAllVariationsForExerciseId($id);
            $exerciseProgressions = $this->table->getProgressionTreeByExerciseID($id);
        } catch (\Exception $e) {
            die('error');
           // return $this->redirect()->toRoute('application', ['action' => 'index']);
        }

        return new ViewModel([
            'exerciseName' => $exerciseName, 
            'exerciseClassifications' => $exerciseClassifications,
            'exerciseTags' => $exerciseTags,
            'exerciseExamples' => $exerciseExamples,
            'exerciseReadings' => $exerciseReadings,
            'exerciseVariations' => $exerciseVariations,
            'exerciseProgressions' => $exerciseProgressions
        ]);
    }
}