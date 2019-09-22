<?php
namespace News\Command\News;

use Marmot\Framework\Interfaces\ICommand;

class AddNewsCommand implements ICommand
{
    public $title;

    public $source;

    public $image;

    public $attachments;

    public $content;

    public $publishUserGroupId;

    public function __construct(
        string $title,
        string $source,
        array $image,
        array $attachments,
        string $content,
        int $publishUserGroupId,
        int $id = 0
    ) {
        $this->title = $title;
        $this->source = $source;
        $this->image = $image;
        $this->attachments = $attachments;
        $this->content = $content;
        $this->publishUserGroupId = $publishUserGroupId;
        $this->id = $id;
    }
}
