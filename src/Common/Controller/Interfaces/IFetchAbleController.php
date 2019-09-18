<?php
namespace Common\Controller\Interfaces;

interface IFetchAbleController
{
    public function fetchOne(int $id);

    public function fetchList(string $ids);

    public function filter();
}
