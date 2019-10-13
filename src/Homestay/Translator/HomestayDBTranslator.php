<?php
namespace Homestay\Translator;

use Marmot\Interfaces\ITranslator;

use Homestay\Model\Homestay;
use Homestay\Model\NullHomestay;

class HomestayDBTranslator implements ITranslator
{
    /**
     * @SuppressWarnings(PHPMD.CyclomaticComplexity)
     * @SuppressWarnings(PHPMD.NPathComplexity)
     */
    public function arrayToObject(array $expression, $homestay = null)
    {
        if (!isset($expression['homestay_id'])) {
            return NullHomestay::getInstance();
        }

        if ($homestay == null) {
            $homestay = new Homestay($expression['homestay_id']);
        }
        
        if (isset($expression['name'])) {
            $homestay->setName($expression['name']);
        }
        if (is_string($expression['logo'])) {
            $homestay->setLogo(json_decode($expression['logo'], true));
        }
        if (isset($expression['create_time'])) {
            $homestay->setCreateTime($expression['create_time']);
        }
        if (isset($expression['update_time'])) {
            $homestay->setUpdateTime($expression['update_time']);
        }
        if (isset($expression['status'])) {
            $homestay->setStatus($expression['status']);
        }
        if (isset($expression['status_time'])) {
            $homestay->setStatusTime($expression['status_time']);
        }

        return $homestay;
    }

    /**
     * @SuppressWarnings(PHPMD)
     */
    public function objectToArray($homestay, array $keys = array())
    {
        if (!$homestay instanceof Homestay) {
            return false;
        }

        if (empty($keys)) {
            $keys = array(
                'id',
                'name',
                'logo',
                'createTime',
                'updateTime',
                'status',
                'statusTime'
            );
        }

        $expression = array();

        if (in_array('id', $keys)) {
            $expression['homestay_id'] = $homestay->getId();
        }
        if (in_array('name', $keys)) {
            $expression['name'] = $homestay->getName();
        }
        if (in_array('logo', $keys)) {
            $expression['logo'] = $homestay->getLogo();
        }
        if (in_array('status', $keys)) {
            $expression['status'] = $homestay->getStatus();
        }
        if (in_array('statusTime', $keys)) {
            $expression['status_time'] = $homestay->getStatusTime();
        }
        if (in_array('createTime', $keys)) {
            $expression['create_time'] = $homestay->getCreateTime();
        }
        if (in_array('updateTime', $keys)) {
            $expression['update_time'] = $homestay->getUpdateTime();
        }

        return $expression;
    }
}
