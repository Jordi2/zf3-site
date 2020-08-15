<?php

namespace Detail\Model;

use DomainException;
use Laminas\InputFilter\InputFilterAwareInterface;
use Laminas\InputFilter\InputFilterInterface;

class Exercises implements InputFilterAwareInterface
{
    public $id;
    public $name;
    public $altNames;
    public $example;
    public $isVariation;
    public $exercise_parent_id;
    public $classifications_id;
    
    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->name = !empty($data['name']) ? $data['name'] : null;
        $this->altNames  = !empty($data['altNames']) ? $data['altNames'] : null;
        $this->example     = !empty($data['example']) ? $data['example'] : null;
        $this->isVariation = !empty($data['isVariation']) ? $data['isVariation'] : null;
        $this->exercise_parent_id  = !empty($data['exercise_parent_id']) ? $data['exercise_parent_id'] : null;
        $this->classifications_id = !empty($data['classifications_id']) ? $data['classifications_id'] : null;
    }
    
    public function getArrayCopy()
    {
        return [
            'id'     => $this->id,
            'name' => $this->name,
            'altNames'  => $this->altNames,
            'example'  => $this->example,
            'isVariation'  => $this->isVariation,
            'exercise_parent_id'  => $this->exercise_parent_id,
            'classifications_id'  => $this->classifications_id,
        ];
    }
    
    public function setInputFilter(InputFilterInterface $inputFilter)
    {
        throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }
    
    public function getInputFilter()
    {
         throw new DomainException(sprintf(
            '%s does not allow injection of an alternate input filter',
            __CLASS__
        ));
    }
}