<?php
namespace News\CommandHandler\News;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use News\Model\News;
use News\Model\ContentDocument;
use News\Command\News\AddNewsCommand;

use UserGroup\Model\UserGroup;
use UserGroup\Repository\UserGroup\UserGroupRepository;

class AddNewsCommandHandler implements ICommandHandler
{
    private $news;

    private $userGroupRepository;

    private $contentDocument;

    public function __construct()
    {
        $this->news = new News();
        $this->userGroupRepository = new UserGroupRepository();
        $this->contentDocument = new ContentDocument();
    }

    public function __destruct()
    {
        unset($this->news);
        unset($this->userGroupRepository);
        unset($this->contentDocument);
    }

    protected function getNews() : News
    {
        return $this->news;
    }

    protected function getUserGroupRepository() : UserGroupRepository
    {
        return $this->userGroupRepository;
    }

    private function fetchUserGroup(int $id) : UserGroup
    {
        return $this->getUserGroupRepository()->fetchOne($id);
    }

    protected function getContentDocument() : ContentDocument
    {
        return $this->contentDocument;
    }

    public function execute(ICommand $command)
    {
        if (!($command instanceof AddNewsCommand)) {
            throw new \InvalidArgumentException;
        }

        $userGroup = $this->fetchUserGroup($command->publishUserGroupId);

        $contentDocument = $this->getContentDocument();
        $contentDocument->setData(array('content'=>$command->content));

        $news = $this->getNews();
        $news->setTitle($command->title);
        $news->setSource($command->source);
        $news->setImage($command->image);
        $news->setAttachments($command->attachments);
        $news->setContent($contentDocument);
        $news->setPublishUserGroup($userGroup);
        
        if ($news->add()) {
            $command->id = $news->getId();
            return true;
        }
        return false;
    }
}
