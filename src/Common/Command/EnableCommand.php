<?php
namespace Common\Command;

use Marmot\Framework\Interfaces\ICommand;

abstract class EnableCommand implements ICommand
{
    public $id;

    public function __construct(int $id)
    {
        $this->id = $id;
    }
}
