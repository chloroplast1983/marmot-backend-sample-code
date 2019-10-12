<?php
namespace Member\CommandHandler\Member;

use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use Member\Model\Member;
use Member\Command\Member\SignUpMemberCommand;

class SignUpMemberCommandHandler implements ICommandHandler
{
    private $member;

    public function __construct()
    {
        $this->member = new Member();
    }

    public function __destruct()
    {
        unset($this->member);
    }

    protected function getMember()
    {
        return $this->member;
    }

    public function execute(ICommand $command)
    {
        if (!($command instanceof SignUpMemberCommand)) {
            throw new \InvalidArgumentException;
        }

        $member = $this->getMember();
        $member->setCellphone($command->cellphone);
        $member->setUserName($command->cellphone);
        $member->encryptPassword($command->password);

        if ($member->signUp()) {
            $command->id = $member->getId();
            return true;
        }
        return false;
    }
}
