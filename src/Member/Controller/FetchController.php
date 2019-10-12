<?php
namespace Member\Controller;

use Marmot\Interfaces\INull;
use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Controller\JsonApiTrait;

use Common\Controller\Interfaces\IFetchAbleController;

use Member\View\MemberView;
use Member\Repository\Member\MemberRepository;

class FetchController extends Controller implements IFetchAbleController
{
    use JsonApiTrait;

    private $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new MemberRepository();
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->repository);
    }

    protected function getRepository() : MemberRepository
    {
        return $this->repository;
    }

    public function fetchOne(int $id)
    {
        $member = $this->getRepository()->fetchOne($id);

        if (!$member instanceof INull) {
            $this->renderView(new MemberView($member));
            return true;
        }

        $this->displayError();
        return false;
    }

    public function fetchList(string $ids)
    {
        $ids = explode(',', $ids);

        $memberList = array();

        $memberList = $this->getRepository()->fetchList($ids);

        if (!empty($memberList)) {
            $this->renderView(new MemberView($memberList));
            return true;
        }

        $this->displayError();
        return false;
    }

    public function filter()
    {
        list($filter, $sort, $curpage, $perpage) = $this->formatParameters();

        list($memberList, $count) = $this->getRepository()->filter(
            $filter,
            $sort,
            ($curpage-1)*$perpage,
            $perpage
        );

        if ($count > 0) {
            $view = new MemberView($memberList);
            $view->pagination(
                'members',
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
