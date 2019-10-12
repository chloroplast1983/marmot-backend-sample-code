<?php
namespace Member\Command\Member;

use Marmot\Interfaces\ICommand;

class SignUpMemberCommand implements ICommand
{
    /**
     * @var string cellphone 手机号
     */
    public $cellphone;
    /**
     * @var string  password 密码
     */
    public $password;

    public $id;

    public function __construct(
        string $cellphone,
        string $password,
        int $id = 0
    ) {
        $this->cellphone = $cellphone;
        $this->password = $password;
        $this->id = $id;
    }
}
