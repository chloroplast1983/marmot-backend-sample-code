<?php
namespace Homestay\Model;

use Marmot\Core;
use Marmot\Common\Model\Object;
use Marmot\Common\Model\IObject;

class Homestay implements IObject
{
    use Object;

    const STATUS = array(
        'PENDING' => 0, //待审核
        'ONSALE' => 2, //通过
        'OFFSTOCK' => -2, //下架
        'REJECT' => -4 //驳回
    );

    private $id;

    private $name;

    private $logo;

    private $factory;

    public function __construct(int $id = 0)
    {
        $this->id = !empty($id) ? $id : 0;
        $this->name = '';
        $this->logo = array();
        $this->createTime = Core::$container->get('time');
        $this->updateTime = Core::$container->get('time');
        $this->status = self::STATUS['PENDING'];
        $this->statusTime = 0;
        $this->factory = new ModelFactory();
    }

    public function __destruct()
    {
        unset($this->id);
        unset($this->name);
        unset($this->logo);
        unset($this->statusTime);
        unset($this->createTime);
        unset($this->updateTime);
        unset($this->status);
        unset($this->factory);
    }

    public function setId($id) : void
    {
        $this->id = $id;
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

    public function setLogo(array $logo) : void
    {
        $this->logo = $logo;
    }

    public function getLogo() : array
    {
        return $this->logo;
    }

    public function setStatus(int $status) : void
    {
        $this->status = in_array($status, self::STATUS) ? $status : self::STATUS['PENDING'];
    }

    protected function getFactory() : ModelFactory
    {
        return $this->factory;
    }

    public function add(Homestay $homestay) : bool
    {
        $model = $this->getModel($homestay->getStatus());

        return $model->add($homestay);
    }

    public function edit(Homestay $homestay) : bool
    {
        $model = $this->getModel($homestay->getStatus());
        
        return $model->edit($homestay);
    }

    private function getModel(int $status)
    {
        return $model = $this->getFactory()->getModel($status);
    }
}
