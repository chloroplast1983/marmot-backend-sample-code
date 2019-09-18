<?php
namespace UserGroup\Controller;

use Marmot\Framework\Interfaces\INull;
use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Controller\JsonApiTrait;

use Common\Controller\Interfaces\IFetchAbleController;

use UserGroup\View\UserGroupView;
use UserGroup\Repository\UserGroup\UserGroupRepository;

class FetchController extends Controller implements IFetchAbleController
{
    use JsonApiTrait;

    private $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new UserGroupRepository();
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->repository);
    }

    protected function getRepository() : UserGroupRepository
    {
        return $this->repository;
    }

    public function fetchOne(int $id)
    {
        $userGroup = $this->getRepository()->fetchOne($id);

        if (!$userGroup instanceof INull) {
            $this->renderView(new UserGroupView($userGroup));
            return true;
        }

        $this->displayError();
        return false;
    }

    public function fetchList(string $ids)
    {
        $ids = explode(',', $ids);

        $userGroupList = array();

        $userGroupList = $this->getRepository()->fetchList($ids);

        if (!empty($userGroupList)) {
            $this->renderView(new UserGroupView($userGroupList));
            return true;
        }

        $this->displayError();
        return false;
    }

    public function filter()
    {
        list($filter, $sort, $curpage, $perpage) = $this->formatParameters();

        list($userGroupList, $count) = $this->getRepository()->filter(
            $filter,
            $sort,
            ($curpage-1)*$perpage,
            $perpage
        );

        if ($count > 0) {
            $view = new UserGroupView($userGroupList);
            $view->pagination(
                'userGroup',
                $this->getRequest()->get(),
                $count,
                $perpage,
                $curpage
            );
            $this->renderView($view);
            return true;
        }

        $this->displayError();
        return false;
    }
}
