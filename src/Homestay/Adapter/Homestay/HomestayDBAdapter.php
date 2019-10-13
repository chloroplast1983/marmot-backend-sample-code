<?php
namespace Homestay\Adapter\Homestay;

use Marmot\Core;

use Common\Adapter\FetchRestfulAdapterTrait;

use Homestay\Model\Homestay;
use Homestay\Model\NullHomestay;
use Homestay\Translator\HomestayDBTranslator;
use Homestay\Adapter\Homestay\Query\HomestayRowCacheQuery;

class HomestayDBAdapter implements IHomestayAdapter
{
    use FetchRestfulAdapterTrait;

    private $translator;

    private $rowCacheQuery;

    public function __construct()
    {
        $this->translator = new HomestayDBTranslator();
        $this->rowCacheQuery = new HomestayRowCacheQuery();
    }

    public function __destruct()
    {
        unset($this->translator);
        unset($this->rowCacheQuery);
    }
    
    protected function getDBTranslator() : HomestayDBTranslator
    {
        return $this->translator;
    }
    
    protected function getRowCacheQuery() : HomestayRowCacheQuery
    {
        return $this->rowCacheQuery;
    }
    
    public function add(Homestay $homestay, array $keys = array()) : bool
    {
        $info = array();
        
        $info = $this->getDBTranslator()->objectToArray($homestay, $keys);

        $id = $this->getRowCacheQuery()->add($info);

        if (!$id) {
            return false;
        }

        $homestay->setId($id);
        return true;
    }

    public function edit(Homestay $homestay, array $keys = array()) : bool
    {
        $info = array();

        $conditionArray[$this->getRowCacheQuery()->getPrimaryKey()] = $homestay->getId();

        $info = $this->getDBTranslator()->objectToArray($homestay, $keys);

        $result = $this->getRowCacheQuery()->update($info, $conditionArray);
        
        if (!$result) {
            return false;
        }

        return true;
    }

    public function fetchOne($id) : Homestay
    {
        $info = array();

        $info = $this->getRowCacheQuery()->getOne($id);

        if (empty($info)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return NullHomestay::getInstance();
        }

        $homestay = $this->getDBTranslator()->arrayToObject($info);

        return $homestay;
    }

    public function fetchList(array $ids) : array
    {
        $homestayList = array();
        
        $homestayInfoList = $this->getRowCacheQuery()->getList($ids);

        if (empty($homestayInfoList)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return array();
        }

        $translator = $this->getDBTranslator();

        foreach ($homestayInfoList as $homestayInfo) {
            $homestayList[] = $translator->arrayToObject($homestayInfo);
        }

        return $homestayList;
    }

    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     */
    protected function formatFilter(array $filter) : string
    {
        $condition = $conjection = '';

        if (!empty($filter)) {
            $homestay = new Homestay();

            if (isset($filter['name']) && !empty($filter['name'])) {
                $homestay->setName($filter['name']);
                $info = $this->getDBTranslator()->objectToArray($homestay, array('name'));
                $condition .= $conjection.key($info).' LIKE \'%'.current($info).'%\'';
                $conjection = ' AND ';
            }
            if (isset($filter['status'])) {
                $status = $filter['status'];
                if (is_numeric($status)) {
                    $homestay->setStatus($filter['status']);
                    $info = $this->getDBTranslator()->objectToArray(
                        $homestay,
                        array('status')
                    );
                    $condition .= $conjection.key($info).' = '.current($info);
                }
                if (strpos($status, ',')) {
                    $info = $this->getDBTranslator()->objectToArray(
                        $homestay,
                        array('status')
                    );
                    $condition .= $conjection.key($info).' IN ('.$status.')';
                }
                $conjection = ' AND ';
            }
        }

        return empty($condition) ? ' 1 ' : $condition ;
    }

    protected function formatSort(array $sort) : string
    {
        $condition = '';
        $conjection = ' ORDER BY ';

        if (!empty($sort)) {
            $homestay = new Homestay();
            if (isset($sort['updateTime'])) {
                $info = $this->getDBTranslator()->objectToArray($homestay, array('updateTime'));
                $condition .= $conjection.key($info).' '.($sort['updateTime'] == -1 ? 'DESC' : 'ASC');
                $conjection = ',';
            }
            if (isset($sort['status'])) {
                $info = $this->getDBTranslator()->objectToArray($homestay, array('status'));
                $condition .= $conjection.key($info).' '.($sort['status'] == -1 ? 'DESC' : 'ASC');
                $conjection = ',';
            }
            if (isset($sort['id'])) {
                $info = $this->getDBTranslator()->objectToArray($homestay, array('id'));
                $condition .= $conjection.key($info).' '.($sort['id'] == -1 ? 'DESC' : 'ASC');
                $conjection = ',';
            }
        }

        return $condition;
    }
}
