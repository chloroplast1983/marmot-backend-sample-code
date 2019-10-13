<?php
namespace Homestay\CommandHandler\Homestay;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use Homestay\Model\Homestay;
use Homestay\Repository\Homestay\HomestayRepository;
use Homestay\Command\Homestay\EditCommand;

class EditCommandHandler implements ICommandHandler
{
    private $homestay;

    private $repository;

    public function __construct()
    {
        $this->homestay = new Homestay();
        $this->repository = new HomestayRepository();
    }

    public function __destruct()
    {
        unset($this->homestay);
        unset($this->repository);
    }

    protected function getHomestay() : Homestay
    {
        return $this->homestay;
    }

    protected function getRepository() : HomestayRepository
    {
        return $this->repository;
    }

    protected function fetchHomestay(int $id) : Homestay
    {
        return $this->getRepository()->fetchOne($id);
    }

    public function execute(ICommand $command)
    {
        if (!($command instanceof EditCommand)) {
            throw new \InvalidArgumentException;
        }

        $homestay = $this->fetchHomestay($command->id);
        $homestay->setName($command->name);
        $homestay->setLogo($command->logo);

        return $homestay->edit($homestay);
    }
}
