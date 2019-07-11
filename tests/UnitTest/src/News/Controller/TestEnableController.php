<?php
namespace News\Controller;

use Marmot\Framework\Classes\CommandBus;

use News\Repository\News\NewsRepository;

class TestEnableController extends EnableController
{
    public function getRepository() : NewsRepository
    {
        return parent::getRepository();
    }

    public function getCommandBus() : CommandBus
    {
        return parent::getCommandBus();
    }
}
