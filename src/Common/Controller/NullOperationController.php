<?php
namespace Common\Controller;

use Marmot\Core;
use Marmot\Interfaces\INull;

use Common\Controller\Interfaces\IOperatAbleController;

class NullOperationController implements IOperatAbleController, INull
{
    public function add()
    {
        Core::setLastError(ROUTE_NOT_EXIST);
    }

    public function edit(int $id)
    {
        unset($id);
        Core::setLastError(ROUTE_NOT_EXIST);
    }
}
