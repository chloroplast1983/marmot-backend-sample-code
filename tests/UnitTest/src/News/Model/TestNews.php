<?php
namespace News\Model;

use News\Repository\News\NewsRepository;
use News\Adapter\News\ContentDocumentAdapter;

class TestNews extends News
{
    public function getRepository() : NewsRepository
    {
        return parent::getRepository();
    }

    public function getContentDocumentAdapter() : ContentDocumentAdapter
    {
        return parent::getContentDocumentAdapter();
    }

    public function addAction() : bool
    {
        return parent::addAction();
    }

    public function editAction() : bool
    {
        return parent::editAction();
    }

    public function updateStatus(int $status) : bool
    {
        return parent::updateStatus($status);
    }
}
