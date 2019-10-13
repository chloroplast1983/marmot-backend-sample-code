<?php
namespace Homestay\Model;

use Marmot\Core;

use Homestay\Repository\Homestay\HomestayRepository;

class PendingHomestay extends Homestay
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
        return $this->getRepository()->add($homestay);
    }

    public function edit(Homestay $homestay) : bool
    {            
        Core::setLastError(RESOURCE_STATUS_NOT_NORMAL);
        return false;
    }
}
