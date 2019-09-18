<?php
namespace News\CommandHandler\News;

use News\Model\News;
use News\Repository\News\NewsRepository;

trait NewsCommandHandlerTrait
{
    protected function getRepository() : NewsRepository
    {
        return new NewsRepository();
    }
    
    protected function fetchNews(int $id) : News
    {
        return $this->getRepository()->fetchOne($id);
    }
}
