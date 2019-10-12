<?php
namespace Member\Command\Member;

use Marmot\Interfaces\ICommand;

class SignInMemberCommand implements ICommand
{
    /**
     * @var string passport 登录凭证
     */
    public $passport;
    /**
     * @var string  password 密码
     */
    public $password;

    public $id;

    public function __construct(
        string $passport,
        string $password,
        int $id = 0
    ) {
        $this->passport = $passport;
        $this->password = $password;
        $this->id = $id;
    }
}
