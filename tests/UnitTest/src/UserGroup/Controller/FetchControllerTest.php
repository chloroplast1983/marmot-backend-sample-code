<?php
namespace UserGroup\Controller;

use PHPUnit\Framework\TestCase;

use Utility\ControllerTestCase;

use UserGroup\Model\NullUserGroup;
use UserGroup\Utils\ObjectGenerate;
use UserGroup\Repository\UserGroup\UserGroupRepository;

class FetchControllerTest extends ControllerTestCase
{
    private $childStub;

    public function setUp()
    {
        $this->stub = new FetchController();

        $this->childStub = new class extends FetchController
        {
            public function getRepository() : UserGroupRepository
            {
                return parent::getRepository();
            }
        };
    }

    public function teatDown()
    {
        unset($this->childStub);
    }

    public function testGetRepository()
    {
        $this->assertInstanceOf(
            'UserGroup\Repository\UserGroup\UserGroupRepository',
            $this->childStub->getRepository()
        );
    }

    public function testFetchOneSuccess()
    {
        $userGroup = ObjectGenerate::generateUserGroup(1);

        $this->fetchOneSuccess(
            [
                'repository'=>UserGroupRepository::class,
                'controller'=>FetchController::class
            ],
            'getRepository',
            $userGroup
        );
    }

    public function testFetchOneFailure()
    {
        $userGroup = new NullUserGroup();

        $this->fetchOneFailure(
            [
                'repository'=>UserGroupRepository::class,
                'controller'=>FetchController::class
            ],
            'getRepository',
            $userGroup
        );
    }

    public function testFetchListSuccess()
    {
        $userGroupArray = array(
            ObjectGenerate::generateUserGroup(1)
        );

        $this->fetchListSuccess(
            [
                'repository'=>UserGroupRepository::class,
                'controller'=>FetchController::class
            ],
            'getRepository',
            $userGroupArray
        );
    }

    public function testFetchListFailure()
    {
        $userGroupArray = array();

        $this->fetchListFailure(
            [
                'repository'=>UserGroupRepository::class,
                'controller'=>FetchController::class
            ],
            'getRepository',
            $userGroupArray
        );
    }

    public function testFilterSuccess()
    {
        $userGroupArray = array(
            array(ObjectGenerate::generateUserGroup(1)),
            1
        );

        $this->filterSuccess(
            [
                'repository'=>UserGroupRepository::class,
                'controller'=>FetchController::class
            ],
            'getRepository',
            $userGroupArray
        );
    }

    public function testFilterFailure()
    {
        $userGroupArray = array(array(), 0);

        $this->filterFailure(
            [
                'repository'=>UserGroupRepository::class,
                'controller'=>FetchController::class
            ],
            'getRepository',
            $userGroupArray
        );
    }
}
