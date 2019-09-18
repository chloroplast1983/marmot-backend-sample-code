<?php
namespace Common\Controller;

use Marmot\Core;
use Marmot\Framework\Interfaces\INull;

use Common\Controller\Interfaces\IEnableAbleController;

class NullEnableController implements IEnableAbleController, INull
{
    public function enable(int $id)
    {
        unset($id);
        Core::setLastError(ROUTE_NOT_EXIST);
    }
    
    public function disable(int $id)
    {
        unset($id);
        Core::setLastError(ROUTE_NOT_EXIST);
    }
}
