<?php

namespace Detail\Model;

use RuntimeException;
use Laminas\Db\Adapter\AdapterInterface;
use Laminas\Db\TableGateway\TableGatewayInterface;
use Zend\Db\Sql\Sql;
use Zend\Db\Sql\Where;

class ExercisesTable
{
    private $tableGateway;
    private $dbAdapter;

    public function __construct(TableGatewayInterface $tableGateway)
    {
        $this->tableGateway = $tableGateway;
        $this->dbAdapter = $tableGateway->getDbAdapter();
    }

    public function fetchAll()
    {
        $sqlSelect = $this->tableGateway->getSql()->select()->order('name ASC');
        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        return $statement->execute();  
    }
    
    public function getExercise($id)
    {
        $id = (int) $id;
        $rowset = $this->tableGateway->select(['id' => $id]);
        $row = $rowset->current();
        if (! $row) {
            throw new RuntimeException(sprintf(
                'Could not find row with identifier %d',
                $id
            ));
        }

        return $row;
    }
    
    public function getExerciseTemp($id)
    {
        $exerciseID = (int) $id;

        $sql = new Sql($this->dbAdapter);
        $select2 = $sql->select();
        $select2->from('exercises');
        $select2->where(array('id' => $exerciseID));

        $selectString = $sql->getSqlStringForSqlObject($select2);
        $results = $this->dbAdapter->query($selectString, $this->dbAdapter::QUERY_MODE_EXECUTE);
        return $results;
    }
    
    public function getAllClassificationsByExerciseId($id)
    {
        $sql = new Sql($this->dbAdapter);
        $select2 = $sql->select();
        $select2->from('classifications');
        $select2->join('exercises', 'classifications.id = exercises.classifications_id', array(), 'inner');
        $select2->where(array('exercises.id' => $id));

        $selectString = $sql->getSqlStringForSqlObject($select2);
        $results = $this->dbAdapter->query($selectString, $this->dbAdapter::QUERY_MODE_EXECUTE);

        return $results;
        
        /*$where = new Where();
        $where->equalTo('exercises.id', $id);
        $sqlSelect = $this->tableGateway->getSql()->select();
        //$sqlSelect->columns(array());
        $sqlSelect->join('classifications', 'classifications.id = exercises.classifications_id', array('name'), 'inner');
        $sqlSelect->where($where);

        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $resultSet;*/
        
        /*$exerciseID = (int) $id;
        
        $sql = new Sql($this->dbAdapter);
        $select2 = $sql->select();
        $select2->from(array('a' => 'exercises'))  // base table
           ->join(array('b' => 'classifications'),     // join table with alias
           'a.classifications_id = b.id')         // join expression
            ->where(array('a.id' => $exerciseID));

        $selectString = $sql->getSqlStringForSqlObject($select2);
        $results = $this->dbAdapter->query($selectString, $this->dbAdapter::QUERY_MODE_EXECUTE);

        return $results;*/
    }
    
    public function getAllTagForExerciseId($id)
    {
        $where = new Where();
        $where->equalTo('exercises.id', $id);
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->join('exercise_tags', 'exercise_tags.exercise_id = exercises.id', array(), 'inner');
        $sqlSelect->join('tags', 'tags.id = exercise_tags.tag_id', array('name'), 'inner');
        $sqlSelect->where($where);

        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();

        return $resultSet;
        
        
        $exerciseID = (int) $id;
        
        $sql = new Sql($this->dbAdapter);
        $select2 = $sql->select();
        $select2->from(array('a' => 'exercises')) 
           ->join(array('b' => 'exercise_tags'),   
           'a.id = b.exercise_id')      
                ->join(array('c' => 'tags'), 
                    'c.id = b.tag_id')
            ->where(array('a.id' => $exerciseID));

        $selectString = $sql->getSqlStringForSqlObject($select2);
        $results = $this->dbAdapter->query($selectString, $this->dbAdapter::QUERY_MODE_EXECUTE);

        return $results;
    }
    
    public function getAllReadingsForExerciseId($id)
    {
        $exerciseID = (int) $id;
        
        $sql = new Sql($this->dbAdapter);
        $select2 = $sql->select();
        $select2->from(array('a' => 'exercises')) 
           ->join(array('b' => 'readings'),   
           'a.id = b.exercise_id')      
            ->where(array('a.id' => $exerciseID));

        $selectString = $sql->getSqlStringForSqlObject($select2);
        $results = $this->dbAdapter->query($selectString, $this->dbAdapter::QUERY_MODE_EXECUTE);

        return $results;
    }
    
    public function getAllVariationsForExerciseId($id)
    {
        $exerciseID = (int) $id;
        
        $sql = new Sql($this->dbAdapter);
        $select2 = $sql->select();
        $select2->from(array('a' => 'exercises')) 
           ->join(array('b' => 'exercises'),   
           'a.id = b.exercise_parent_id')      
            ->where(array('a.id' => $exerciseID, 'b.isVariation' => TRUE));

        $selectString = $sql->getSqlStringForSqlObject($select2);
        $results = $this->dbAdapter->query($selectString, $this->dbAdapter::QUERY_MODE_EXECUTE);

        return $results;
    }
    
    public function getProgressionTreeByFilter($classificationsIds, $tagIds, $showVariations)
    {
        $filterQuery = '';
        // Don't show variations
        $variationFilterQuery = 'ep.isVariation = false AND ';
        
        if($showVariations)
            // Show variations
            $variationFilterQuery = '';

        if($classificationsIds != null && $tagIds != null){
            $filterQuery = '
                INNER JOIN exercise_tags et ON et.exercise_id = ep.`id` 
                WHERE 
                    '.$variationFilterQuery.'
                    ep.classifications_id IN ('.$classificationsIds.' ) AND
                    et.tag_id IN ('.$tagIds.')';
        }
        else if ($classificationsIds != null){
            $filterQuery = '
                WHERE 
                    '.$variationFilterQuery.'
                    ep.classifications_id IN ('.$classificationsIds.')';
        }
        else if ($tagIds != null){
            $filterQuery = '
                INNER JOIN exercise_tags et ON et.exercise_id = ep.`id` 
                WHERE 
                    '.$variationFilterQuery.'
                    et.tag_id IN ('.$tagIds.')';
        } else if (!$showVariations){
            $filterQuery = '
                WHERE 
                    ep.isVariation = false ';
        }
        
        $results = $this->dbAdapter->query('
                WITH RECURSIVE employee_paths AS
                ( 
                    SELECT e1.*
                        FROM exercises e1
                        WHERE 
                            e1.exercise_parent_id IS NULL
                     UNION ALL

                    SELECT e2.*
                    FROM exercises e2
                    INNER JOIN employee_paths ep ON ep.id = e2.exercise_parent_id
                )
                SELECT *
                FROM employee_paths ep
                '.$filterQuery.'
                ORDER BY ep.classifications_id, ep.exercise_parent_id, ep.difficulty
                
                ', $this->dbAdapter::QUERY_MODE_EXECUTE);
        
        return $results;
    }
    
    public function getProgressionTreeByExerciseID($id)
    {
        $results = $this->dbAdapter->query('
            WITH RECURSIVE employee_paths AS
            ( 
                SELECT e1.*
                    FROM exercises e1
                    WHERE 
                        e1.exercise_parent_id IS NULL
                 UNION ALL

                SELECT e2.*
                FROM exercises e2
                INNER JOIN employee_paths ep ON ep.id = e2.exercise_parent_id 
                WHERE e2.isVariation = 0
            )
            SELECT *
            FROM employee_paths ep
            ', $this->dbAdapter::QUERY_MODE_EXECUTE);
        
        return $results;
    }
    
    public function getProgressionTreeByExerciseClassification($id)
    {
        $results = $this->dbAdapter->query('
            WITH RECURSIVE employee_paths AS
            ( 
                SELECT e1.*
                    FROM exercises e1
                    WHERE 
                        e1.exercise_parent_id IS NULL AND
                        e1.classifications_id = (
                            SELECT `classifications_id` 
                            FROM exercises 
                            WHERE id = '.$id.' 
                            LIMIT 1
                        )
                 UNION ALL

                SELECT e2.*
                FROM exercises e2
                INNER JOIN employee_paths ep ON ep.id = e2.exercise_parent_id 
            )
            SELECT *
            FROM employee_paths ep
            ', $this->dbAdapter::QUERY_MODE_EXECUTE);
        
        return $results;
    }
    
    public function getAllExercisesForSearch($keyword)
    {  
        $where = new Where();
        if($keyword != null && ! ctype_space($keyword))
            $where->like('name', '%'.$keyword.'%');
        $sqlSelect = $this->tableGateway->getSql()->select();
        $sqlSelect->where($where);

        $statement = $this->tableGateway->getSql()->prepareStatementForSqlObject($sqlSelect);
        $resultSet = $statement->execute();
        
        return $resultSet;
    }
    
    public function getAllClassifications()
    {
        $sql = new Sql($this->dbAdapter);
        $select2 = $sql->select();
        $select2->from('classifications');

        $selectString = $sql->getSqlStringForSqlObject($select2);
        $results = $this->dbAdapter->query($selectString, $this->dbAdapter::QUERY_MODE_EXECUTE);

        return $results;
    }
    
    public function getAllTags()
    {
        $sql = new Sql($this->dbAdapter);
        $select2 = $sql->select();
        $select2->from('tags');

        $selectString = $sql->getSqlStringForSqlObject($select2);
        $results = $this->dbAdapter->query($selectString, $this->dbAdapter::QUERY_MODE_EXECUTE);

        return $results;
    }
}