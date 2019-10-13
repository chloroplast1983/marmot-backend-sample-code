<?php
namespace Homestay\Model;

use Marmot\Core;

use Homestay\Repository\Homestay\HomestayRepository;

class OffStockHomestay extends Homestay
{
    private $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new HomestayRepository();
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->repository);
    }

    protected function getRepository() : HomestayRepository
    {
        return $this->repository;
    }

    public function add(Homestay $homestay) : bool
    {
        return false;
    }
    
    public function edit(Homestay $homestay) : bool
    {
        $homestay->setUpdateTime(Core::$container->get('time'));
        $homestay->setStatus(Homestay::STATUS['PENDING']);

        return $this->getRepository()->edit($homestay);
    }
}
