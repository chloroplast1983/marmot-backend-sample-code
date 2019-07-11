<?php
namespace UserGroup\Model;

use Marmot\Core;
use Marmot\Common\Model\Object;
use Marmot\Common\Model\IObject;

use UserGroup\Repository\UserGroup\UserGroupRepository;

class UserGroup implements IObject
{
    use Object;

    const STATUS_NORMAL = 0;
    const STATUS_DELETE = -2;

    private $id;

    private $name;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->name = '';
        $this->status = self::STATUS_NORMAL;
        $this->updateTime = Core::$container->get('time');
        $this->statusTime = 0;
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->name);
        unset($this->createTime);
        unset($this->status);
        unset($this->updateTime);
        unset($this->statusTime);
    }

    public function setId($id) : void
    {
        $this->id = intval($id);
    }

    public function getId() : int
    {
        return $this->id;
    }

    public function setName(string $name) : void
    {
        $this->name = $name;
    }

    public function getName() : string
    {
        return $this->name;
    }

    public function setStatus(int $status) : void
    {
        $this->status= in_array(
            $status,
            array(
                self::STATUS_NORMAL,
                self::STATUS_DELETE
            )
        ) ? $status : self::STATUS_NORMAL;
    }
}
