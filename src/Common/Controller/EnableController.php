<?php
namespace Common\Controller;

use Marmot\Framework\Classes\Controller;

use Common\Controller\Factory\EnableControllerFactory;
use Common\Controller\Interfaces\IEnableAbleController;

class EnableController extends Controller
{
    protected function getController(string $resource) : IEnableAbleController
    {
        return EnableControllerFactory::getController($resource);
    }

    public function enable(string $resource, int $id)
    {
        $controller = $this->getController($resource);
        
        return $controller->enable($id);
    }
    
    public function disable(string $resource, int $id)
    {
        $controller = $this->getController($resource);
        
        return $controller->disable($id);
    }
}
