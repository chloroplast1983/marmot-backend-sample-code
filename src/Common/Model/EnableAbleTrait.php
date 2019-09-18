<?php
namespace Common\Model;

use Marmot\Core;

trait EnableAbleTrait
{
    /**
     * 设置状态
     * @param int $status 状态
     */
    public function setStatus(int $status) : void
    {
        $this->status = in_array(
            $status,
            array(
                self::STATUS['ENABLED'],
                self::STATUS['DISABLED']
            )
        ) ? $status : self::STATUS['ENABLED'];
    }
    
    /**
     * 启用
     * @return bool 是否启用成功
     */
    public function enable() : bool
    {
        if (!$this->isDisabled()) {
            Core::setLastError(RESOURCE_STATUS_ENABLED);
            return false;
        }
        
        return $this->updateStatus(self::STATUS['ENABLED']);
    }

    /**
     * 禁用
     * @return bool 是否禁用成功
     */
    public function disable() : bool
    {
        if (!$this->isEnabled()) {
            Core::setLastError(RESOURCE_STATUS_DISABLED);
            return false;
        }
        return $this->updateStatus(self::STATUS['DISABLED']);
    }

    abstract protected function updateStatus(int $status) : bool;

    public function isEnabled() : bool
    {
        return $this->getStatus() == self::STATUS['ENABLED'];
    }

    public function isDisabled() : bool
    {
        return $this->getStatus() == self::STATUS['DISABLED'];
    }
}
