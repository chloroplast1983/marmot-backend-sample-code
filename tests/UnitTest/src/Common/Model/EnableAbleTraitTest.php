<?php
namespace Common\Model;

use Marmot\Core;

use PHPUnit\Framework\TestCase;

class EnableAbleTraitTest extends TestCase
{
    private $trait;

    public function setUp()
    {
        $this->trait = $this->getMockBuilder(MockEnableAbleTrait::class)
                            ->setMethods(['updateStatus'])
                            ->getMock();
    }

    public function tearDown()
    {
        unset($this->trait);
    }

    /**
     * @dataProvider statusDataProvider
     */
    public function testSetStatus($actural, $expected)
    {
        $this->trait->setStatus($actural);
        $result = $this->trait->getStatus();
        $this->assertEquals($expected, $result);
    }

    public function statusDataProvider()
    {
        return [
            [IEnableAble::STATUS['ENABLED'], IEnableAble::STATUS['ENABLED']],
            [IEnableAble::STATUS['DISABLED'], IEnableAble::STATUS['DISABLED']],
            [999, IEnableAble::STATUS['ENABLED']]
        ];
    }

    public function testEnableSuccess()
    {
        $this->trait->setStatus(IEnableAble::STATUS['DISABLED']);

        $this->trait->expects($this->exactly(1))
                    ->method('updateStatus')
                    ->with(IEnableAble::STATUS['ENABLED'])
                    ->willReturn(true);

        $result = $this->trait->enable();
        $this->assertTrue($result);
    }

    public function testEnableFail()
    {
        $this->trait->setStatus(IEnableAble::STATUS['ENABLED']);

        $result = $this->trait->enable();
        $this->assertEquals(Core::getLastError()->getId(), RESOURCE_STATUS_ENABLED);
        $this->assertFalse($result);
    }

    public function testDisableSuccess()
    {
        $this->trait->setStatus(IEnableAble::STATUS['ENABLED']);

        $this->trait->expects($this->exactly(1))
                    ->method('updateStatus')
                    ->with(IEnableAble::STATUS['DISABLED'])
                    ->willReturn(true);

        $result = $this->trait->disable();
        $this->assertTrue($result);
    }

    public function testDisableFail()
    {
        $this->trait->setStatus(IEnableAble::STATUS['DISABLED']);

        $result = $this->trait->disable();
        $this->assertEquals(Core::getLastError()->getId(), RESOURCE_STATUS_DISABLED);
        $this->assertFalse($result);
    }
}
