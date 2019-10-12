<?php
namespace Member\CommandHandler\Member;

use Marmot\Core;
use Marmot\Interfaces\ICommand;
use Marmot\Interfaces\ICommandHandler;

use Member\Model\Member;
use Member\Command\Member\SignInMemberCommand;
use Member\Repository\Member\MemberRepository;

class SignInMemberCommandHandler implements ICommandHandler
{
    private $member;
    
    private $memberRepository;

    public function __construct()
    {
        $this->member = new Member();
        $this->memberRepository = new MemberRepository();
    }

    public function __destruct()
    {
        unset($this->member);
        unset($this->memberRepository);
    }

    protected function getMember() : Member
    {
        return $this->member;
    }

    protected function getMemberRepository() : MemberRepository
    {
        return $this->memberRepository;
    }

    public function execute(ICommand $command)
    {
        if (!($command instanceof SignInMemberCommand)) {
            throw new \InvalidArgumentException;
        }

        $this->getMember()->setCellphone($command->passport);
        $this->getMember()->setPassword($command->password);

        list($memberList, $count) = $this->search();

        if (!$this->isValidated($memberList, $count)) {
            return false;
        }

        $this->getMember()->setId($memberList[0]->getId());
        $command->id = $this->getMember()->getId();
        return true;
    }

    private function search() : array
    {
        $filter = array();

        $filter['cellphone'] = $this->getMember()->getCellphone();

        list($memberList, $count) = $this->getMemberRepository()->filter($filter);

        return array($memberList, $count);
    }

    private function isValidated($memberList, $count) : bool
    {
        return $this->isMemberExist($count)
            && $this->isMemberNotDisabled($memberList[0])
            && $this->memberPasswordCorrect($memberList[0]);
    }

    private function isMemberExist($count) : bool
    {
        if (empty($count)) {
            Core::setLastError(RESOURCE_NOT_EXIST);
            return false;
        }

        return true;
    }

    private function isMemberNotDisabled($signInMember) : bool
    {
        if ($signInMember->isDisabled()) {
            Core::setLastError(RESOURCE_STATUS_DISABLED);
            return false;
        }
        return true;
    }

    private function memberPasswordCorrect($signInMember) : bool
    {
        if (!empty($this->getMember()->getPassword())) {
            $this->getMember()->encryptPassword(
                $this->getMember()->getPassword(),
                $signInMember->getSalt()
            );
            if ($signInMember->getPassword() == $this->getMember()->getPassword()) {
                return true;
            }
        }
        Core::setLastError(PASSWORD_INCORRECT);
        return false;
    }
}
