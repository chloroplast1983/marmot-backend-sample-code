<?php
namespace Homestay\Controller;

use Marmot\Interfaces\INull;
use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Controller\JsonApiTrait;

use Common\Controller\Interfaces\IFetchAbleController;

use Homestay\View\HomestayView;
use Homestay\Repository\Homestay\HomestayRepository;

class FetchController extends Controller implements IFetchAbleController
{
    use JsonApiTrait;

    private $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new HomestayRepository();
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->repository);
    }

    protected function getRepository() : HomestayRepository
    {
        return $this->repository;
    }

    public function fetchOne(int $id)
    {
        $homestay = $this->getRepository()->fetchOne($id);

        if (!$homestay instanceof INull) {
            $this->renderView(new HomestayView($homestay));
            return true;
        }

        $this->displayError();
        return false;
    }

    public function fetchList(string $ids)
    {
        $ids = explode(',', $ids);

        $homestayList = array();

        $homestayList = $this->getRepository()->fetchList($ids);

        if (!empty($homestayList)) {
            $this->renderView(new HomestayView($homestayList));
            return true;
        }

        $this->displayError();
        return false;
    }

    public function filter()
    {
        list($filter, $sort, $curpage, $perpage) = $this->formatParameters();

        list($homestayList, $count) = $this->getRepository()->filter(
            $filter,
            $sort,
            ($curpage-1)*$perpage,
            $perpage
        );

        if ($count > 0) {
            $view = new HomestayView($homestayList);
            $view->pagination(
                'homestaies',
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
