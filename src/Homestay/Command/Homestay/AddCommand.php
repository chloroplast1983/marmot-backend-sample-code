<?php
namespace Homestay\Command\Homestay;

use Marmot\Interfaces\ICommand;

class AddCommand implements ICommand
{
    public $name;

    public $logo;

    public function __construct(
        string $name,
        array $logo,
        int $id = 0
    ) {
        $this->name = $name;
        $this->logo = $logo;
        $this->id = $id;
    }
}
