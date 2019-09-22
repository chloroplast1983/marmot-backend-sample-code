<?php
namespace News\Model;

use Marmot\Core;
use Marmot\Common\Model\Object;
use Marmot\Common\Model\IObject;

use Common\Model\IEnableAble;
use Common\Model\IOperatAble;
use Common\Model\EnableAbleTrait;
use Common\Model\OperatAbleTrait;

use News\Repository\News\NewsRepository;
use News\Adapter\News\ContentDocumentAdapter;

use UserGroup\Model\UserGroup;

class News implements IEnableAble, IOperatAble, IObject
{
    use Object, EnableAbleTrait, OperatAbleTrait;

    private $id;

    private $title;

    private $source;

    private $image;

    private $attachments;

    private $content;

    private $publishUserGroup;

    private $repository;

    private $contentDocumentAdapter;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->title = '';
        $this->source = '';
        $this->image = array();
        $this->attachments = array();
        $this->content = new ContentDocument();
        $this->publishUserGroup = new UserGroup();
        $this->createTime = Core::$container->get('time');
        $this->updateTime = Core::$container->get('time');
        $this->status = self::STATUS['ENABLED'];
        $this->statusTime = 0;
        $this->repository = new NewsRepository();
        $this->contentDocumentAdapter = new ContentDocumentAdapter();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->title);
        unset($this->source);
        unset($this->image);
        unset($this->attachments);
        unset($this->content);
        unset($this->publishUserGroup);
        unset($this->statusTime);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->status);
        unset($this->repository);
        unset($this->contentDocumentAdapter);
    }

    public function setId($id) : void
    {
        $this->id = $id;
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setTitle(string $title) : void
    {
        $this->title = $title;
    }

    public function getTitle() : string
    {
        return $this->title;
    }

    public function setSource(string $source) : void
    {
        $this->source = $source;
    }

    public function getSource() : string
    {
        return $this->source;
    }

    public function setImage(array $image) : void
    {
        $this->image = $image;
    }

    public function getImage() : array
    {
        return $this->image;
    }

    public function setAttachments(array $attachments) : void
    {
        $this->attachments = $attachments;
    }

    public function getAttachments() : array
    {
        return $this->attachments;
    }

    public function setContent(ContentDocument $content) : void
    {
        $this->content = $content;
    }

    public function getContent() : ContentDocument
    {
        return $this->content;
    }

    public function setPublishUserGroup(UserGroup $publishUserGroup) : void
    {
        $this->publishUserGroup = $publishUserGroup;
    }

    public function getPublishUserGroup() : UserGroup
    {
        return $this->publishUserGroup;
    }
    
    protected function getRepository() : NewsRepository
    {
        return $this->repository;
    }

    protected function getContentDocumentAdapter() : ContentDocumentAdapter
    {
        return $this->contentDocumentAdapter;
    }

    protected function addAction() : bool
    {
        if (!$this->addContentToMongo()) {
            return false;
        }

        return $this->getRepository()->add($this);
    }

    protected function editAction() : bool
    {
        if (!$this->addContentToMongo()) {
            return false;
        }

        $this->setUpdateTime(Core::$container->get('time'));

        return $this->getRepository()->edit(
            $this,
            array(
                'title',
                'source',
                'image',
                'attachments',
                'content',
                'updateTime'
            )
        );
    }

    private function addContentToMongo() : bool
    {
        return $this->getContentDocumentAdapter()->add($this->getContent());
    }

    protected function updateStatus(int $status) : bool
    {
        $this->setStatus($status);
        $this->setStatusTime(Core::$container->get('time'));
        $this->setUpdateTime(Core::$container->get('time'));

        return $this->getRepository()->edit(
            $this,
            array(
                'statusTime',
                'status',
                'updateTime'
            )
        );
    }
}
