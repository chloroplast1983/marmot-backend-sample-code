<?php
namespace Common\Controller;

use Marmot\Framework\Classes\Controller;

use Common\Controller\Interfaces\IOperatAbleController;
use Common\Controller\Factory\OperationControllerFactory;

class OperationController extends Controller
{
    protected function getController(string $resource) : IOperatAbleController
    {
        return OperationControllerFactory::getController($resource);
    }

    public function add(string $resource)
    {
        $controller = $this->getController($resource);
        return $controller->add();
    }
    
    public function edit(string $resource, int $id)
    {
        $controller = $this->getController($resource);
        return $controller->edit($id);
    }
}
