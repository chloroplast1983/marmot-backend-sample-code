<?php
namespace News\Command\News;

use Marmot\Interfaces\ICommand;

class EditNewsCommand implements ICommand
{
    public $title;

    public $source;

    public $image;

    public $attachments;

    public $content;

    public $id;

    public function __construct(
        string $title,
        string $source,
        array $image,
        array $attachments,
        string $content,
        int $id = 0
    ) {
        $this->title = $title;
        $this->source = $source;
        $this->image = $image;
        $this->attachments = $attachments;
        $this->content = $content;
        $this->id = $id;
    }
}
