<?php
namespace Common\Controller\Interfaces;

interface IEnableAbleController
{
    public function enable(int $id);
    public function disable(int $id);
}
