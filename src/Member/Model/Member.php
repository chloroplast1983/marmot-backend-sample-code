<?php
namespace Member\Model;

use Marmot\Core;
use Marmot\Common\Model\Object;
use Marmot\Common\Model\IObject;

use Common\Model\IEnableAble;
use Common\Model\IOperatAble;
use Common\Model\EnableAbleTrait;
use Common\Model\OperatAbleTrait;

use Member\Repository\Member\MemberRepository;

class Member implements IObject, IEnableAble, IOperatAble
{
    use Object, EnableAbleTrait, OperatAbleTrait;

    const SALT_LENGTH = 4;
    const SALT_BASE = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789abcdefghijklmnopqrstuvwxyz';

    private $id;

    private $cellphone;

    private $userName;

    private $realName;

    private $cardId;

    private $avatar;

    private $password;

    private $oldPassword;

    private $salt;

    private $repository;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->cellphone = '';
        $this->userName = '';
        $this->realName = '';
        $this->cardId = '';
        $this->avatar = array();
        $this->password = '';
        $this->oldPassword = '';
        $this->salt = '';
        $this->status = self::STATUS['ENABLED'];
        $this->updateTime = Core::$container->get('time');
        $this->createTime = Core::$container->get('time');
        $this->statusTime = 0;
        $this->repository = new MemberRepository();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->cellphone);
        unset($this->userName);
        unset($this->realName);
        unset($this->cardId);
        unset($this->avatar);
        unset($this->password);
        unset($this->oldPassword);
        unset($this->salt);
        unset($this->status);
        unset($this->updateTime);
        unset($this->createTime);
        unset($this->statusTime);
        unset($this->repository);
    }

    public function setId($id) : void
    {
        $this->id = intval($id);
    }

    public function getId() : int
    {
        return $this->id;
    }
    
    public function setCellphone(string $cellphone) : void
    {
        $this->cellphone = $cellphone;
    }

    public function getCellphone() : string
    {
        return $this->cellphone;
    }
    
    public function setUserName(string $userName) : void
    {
        $this->userName = $userName;
    }

    public function getUserName() : string
    {
        return $this->userName;
    }
    
    public function setRealName(string $realName) : void
    {
        $this->realName = $realName;
    }

    public function getRealName() : string
    {
        return $this->realName;
    }
    
    public function setCardId(string $cardId) : void
    {
        $this->cardId = $cardId;
    }

    public function getCardId() : string
    {
        return $this->cardId;
    }
    
    public function setAvatar(array $avatar) : void
    {
        $this->avatar = $avatar;
    }

    public function getAvatar() : array
    {
        return $this->avatar;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * 加密用户密码
     * 如果盐不存在则生成盐
     * @param string $salt 盐
     * @return string 返回加密的密码
     */
    public function encryptPassword(string $password, string $salt = '')
    {
        //没有盐,自动生成盐
        $this->salt = empty($salt) ? $this->generateSalt() : $salt;
        $this->password = md5(md5($password).$this->salt);
    }

    /**
     * 随机生成 SALT_LENGTH 长度的盐
     *
     * @return string $salt 盐
     */
    private function generateSalt() : string
    {
        $salt = '';
        $max = strlen(self::SALT_BASE)-1;
        
        for ($i=0; $i<self::SALT_LENGTH; $i++) {
            $salt.=self::SALT_BASE[rand(0, $max)];
        }
        return $salt;
    }
    
    /**
     * 设置salt
     * @param string $salt 盐
     */
    public function setSalt(string $salt)
    {
        $this->salt = $salt;
    }

    /**
     * Gets the value of salt.
     *
     * @return string $salt 用户密码的盐
     */
    public function getSalt() : string
    {
        return $this->salt;
    }
    
    public function setOldPassword(string $oldPassword)
    {
        $this->oldPassword = $oldPassword;
    }

    public function getOldPassword() : string
    {
        return $this->oldPassword;
    }

    protected function getRepository() : MemberRepository
    {
        return $this->repository;
    }

    public function signUp() : bool
    {
        return $this->isCellphoneExist() && $this->getRepository()->add($this);
    }

    protected function isCellphoneExist() : bool
    {
        $filter = array();

        $filter['cellphone'] = $this->getCellphone();

        list($memberList, $count) = $this->getRepository()->filter($filter);
        unset($memberList);
        
        if (!empty($count)) {
            Core::setLastError(PARAMETER_IS_UNIQUE, array('pointer'=>'cellphone'));
            return false;
        }

        return true;
    }

    protected function updateStatus(int $status) : bool
    {
        $this->setStatus($status);
        $this->setStatusTime(Core::$container->get('time'));
        $this->setUpdateTime(Core::$container->get('time'));

        return $this->getRepository()->edit(
            $this,
            array(
                'statusTime',
                'status',
                'updateTime'
            )
        );
    }

    protected function addAction() : bool
    {
        return false;
    }

    protected function editAction() : bool
    {
        return false;
    }
}
