<?php
namespace Common\Controller;

use Marmot\Framework\Classes\Controller;

use Common\Controller\Factory\FetchControllerFactory;
use Common\Controller\Interfaces\IFetchAbleController;

class FetchController extends Controller
{
    protected function getFetchController(string $resource) : IFetchAbleController
    {
        return FetchControllerFactory::getFetchController($resource);
    }
    
    public function fetchOne(string $resource, int $id)
    {
        $fetchController = $this->getFetchController($resource);
        return $fetchController->fetchOne($id);
    }
    
    public function fetchList(string $resource, string $ids)
    {
        $fetchController = $this->getFetchController($resource);
        return $fetchController->fetchList($ids);
    }

    public function filter(string $resource)
    {
        $fetchController = $this->getFetchController($resource);
        return $fetchController->filter();
    }
}
