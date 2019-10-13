<?php
namespace Homestay\CommandHandler\Homestay;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use Homestay\Model\Homestay;
use Homestay\Command\Homestay\AddCommand;

class AddCommandHandler implements ICommandHandler
{
    private $homestay;

    public function __construct()
    {
        $this->homestay = new Homestay();
    }

    public function __destruct()
    {
        unset($this->homestay);
    }

    protected function getHomestay() : Homestay
    {
        return $this->homestay;
    }

    public function execute(ICommand $command)
    {
        if (!($command instanceof AddCommand)) {
            throw new \InvalidArgumentException;
        }

        $homestay = $this->getHomestay();
        $homestay->setName($command->name);
        $homestay->setLogo($command->logo);

        if ($homestay->add($homestay)) {
            $command->id = $homestay->getId();
            return true;
        }
        return false;
    }
}
