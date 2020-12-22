<?php

namespace Detail\Controller;

use Detail\Model\ExercisesTable;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\ViewModel;

class DetailController extends AbstractActionController
{
    private $table;
    
    public function __construct(ExercisesTable $table)
    {
        $this->table = $table;
    }
    
    public function detailAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('application', ['action' => 'index']);
        }
        
        try {
            $exerciseCurrentRow = $this->table->getExercise($id);
            $exerciseClassifications = $this->table->getAllClassificationsByExerciseId($id);
            $exerciseClassifications2 = $this->table->getAllClassificationsByExerciseId($id)->toArray();
            $exerciseDifficulty = $this->table->getAllDifficultyByExerciseId($id);
            $exerciseTags = $this->table->getAllTagForExerciseId($id);
            $exerciseExamples = $this->table->getExerciseTemp($id);
            $exerciseReadings = $this->table->getAllReadingsForExerciseId($id);
            $exerciseVariations = $this->table->getAllVariationsForExerciseId($id);
            $exerciseProgressions = $this->table->getProgressionTreeByExerciseClassification($id);
        } catch (\Exception $e) {
            die('error');
           // return $this->redirect()->toRoute('application', ['action' => 'index']);
        }

        return new ViewModel([
            'exerciseCurrentRow' => $exerciseCurrentRow, 
            'exerciseClassifications' => $exerciseClassifications,
            'exerciseClassifications2' => $exerciseClassifications2,
            'exerciseDifficulty' => $exerciseDifficulty,
            'exerciseTags' => $exerciseTags,
            'exerciseExamples' => $exerciseExamples,
            'exerciseReadings' => $exerciseReadings,
            'exerciseVariations' => $exerciseVariations,
            'exerciseProgressions' => $exerciseProgressions
        ]);
    }
    
    public function joinAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);

        if (0 === $id) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }
        
        try {
            //$albumLinks = $this->table->getAllAlbumLinkByAlbumID($id);
            //$albumLinks = $this->table2->getAlbumLinkByAlbum($id);
            $exerciseNames = $this->table->getExercise($id, $this->adapter);
            $exerciseClassifications = $this->table->getAllClassificationsByExerciseId($id, $this->adapter);
            $exerciseClassifications2 = $this->table->getAllClassificationsByExerciseId($id, $this->adapter)->toArray();
            $exerciseTags = $this->table->getAllTagForExerciseId($id, $this->adapter);
            $exerciseExamples = $this->table->getExercise($id, $this->adapter);
            $exerciseReadings = $this->table->getAllReadingsForExerciseId($id, $this->adapter);
            $exerciseVariations = $this->table->getAllVariationsForExerciseId($id, $this->adapter);
            $exerciseProgressions = $this->table->getProgressionTreeByExerciseID($id, $this->adapter);
        } catch (\Exception $e) {
            return $this->redirect()->toRoute('album', ['action' => 'index']);
        }

        return new ViewModel([
            'exerciseNames' => $exerciseNames, 
            'exerciseClassifications' => $exerciseClassifications,
            'exerciseClassifications2' => $exerciseClassifications2,
            'exerciseTags' => $exerciseTags,
            'exerciseExamples' => $exerciseExamples,
            'exerciseReadings' => $exerciseReadings,
            'exerciseVariations' => $exerciseVariations,
            'exerciseProgressions' => $exerciseProgressions
        ]);
    }
}