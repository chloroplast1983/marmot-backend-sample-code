<?php
namespace Common\Adapter;

use Common\Model\IOperatAble;

trait OperatAbleRestfulAdapterTrait
{
    abstract protected function getDBTranslator();
    
    abstract protected function getRowCacheQuery();

    public function add(IOperatAble $operatAbleObject, array $keys = array()) : bool
    {
        return $this->addAction($operatAbleObject, $keys);
    }

    protected function addAction(IOperatAble $operatAbleObject, array $keys = array()) : bool
    {
        $info = array();
        
        $info = $this->getDBTranslator()->objectToArray($operatAbleObject, $keys);

        $id = $this->getRowCacheQuery()->add($info);

        if (!$id) {
            return false;
        }

        $operatAbleObject->setId($id);
        return true;
    }

    public function edit(IOperatAble $operatAbleObject, array $keys = array()) : bool
    {
        return $this->editAction($operatAbleObject, $keys);
    }

    protected function editAction(IOperatAble $operatAbleObject, array $keys = array()) : bool
    {
        $info = array();

        $conditionArray[$this->getRowCacheQuery()->getPrimaryKey()] = $operatAbleObject->getId();

        $info = $this->getDBTranslator()->objectToArray($operatAbleObject, $keys);

        $result = $this->getRowCacheQuery()->update($info, $conditionArray);
        
        if (!$result) {
            return false;
        }

        return true;
    }
}
