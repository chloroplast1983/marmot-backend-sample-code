<?php
namespace News\CommandHandler\News;

use Marmot\Framework\Interfaces\ICommand;
use Marmot\Framework\Interfaces\ICommandHandler;

use News\Model\ContentDocument;
use News\Command\News\EditNewsCommand;

class EditNewsCommandHandler implements ICommandHandler
{
    use NewsCommandHandlerTrait;

    private $contentDocument;

    public function __construct()
    {
        $this->contentDocument = new ContentDocument();
    }

    public function __destruct()
    {
        unset($this->contentDocument);
    }

    protected function getContentDocument() : ContentDocument
    {
        return $this->contentDocument;
    }

    public function execute(ICommand $command)
    {
        if (!($command instanceof EditNewsCommand)) {
            throw new \InvalidArgumentException;
        }

        $contentDocument = $this->getContentDocument();
        $contentDocument->setData(array('content'=>$command->content));

        $news = $this->fetchNews($command->id);
        $news->setTitle($command->title);
        $news->setSource($command->source);
        $news->setImage($command->image);
        $news->setAttachments($command->attachments);
        $news->setContent($contentDocument);

        return $news->edit();
    }
}
