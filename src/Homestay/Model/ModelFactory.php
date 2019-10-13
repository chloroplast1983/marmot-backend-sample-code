<?php
namespace Homestay\Model;

class ModelFactory
{
    const MAPS = array(
        Homestay::STATUS['PENDING'] => 'Homestay\Model\PendingHomestay',
        Homestay::STATUS['ONSALE'] => 'Homestay\Model\OnSaleHomestay',
        Homestay::STATUS['OFFSTOCK'] => 'Homestay\Model\OffStockHomestay',
        Homestay::STATUS['REJECT'] => 'Homestay\Model\RejectHomestay',
    );

    public function getModel(int $status)
    {
        $model = isset(self::MAPS[$status]) ? self::MAPS[$status] : '';
        
        return class_exists($model) ? new $model : NullHomestay::getInstance();
    }
}
