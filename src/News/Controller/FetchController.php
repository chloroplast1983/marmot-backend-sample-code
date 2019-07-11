<?php
namespace News\Controller;

use Marmot\Framework\Interfaces\INull;
use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Classes\CommandBus;
use Marmot\Framework\Controller\JsonApiTrait;

use Common\Controller\Interfaces\IFetchAbleController;

use News\Model\News;
use News\View\NewsView;
use News\Repository\News\NewsRepository;

class FetchController extends Controller implements IFetchAbleController
{
    use JsonApiTrait;

    private $repository;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new NewsRepository();
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->repository);
    }

    protected function getRepository() : NewsRepository
    {
        return $this->repository;
    }

    public function fetchOne(int $id)
    {
        $repository = $this->getRepository();
        $news = $repository->fetchOne($id);

        if (!$news instanceof INull) {
            $this->renderView(new NewsView($news));
            return true;
        }

        $this->displayError();
        return false;
    }

    public function fetchList(string $ids)
    {
        $ids = explode(',', $ids);

        $newsList = array();

        $repository = $this->getRepository();
        $newsList = $repository->fetchList($ids);

        if (!empty($newsList)) {
            $this->renderView(new NewsView($newsList));
            return true;
        }

        $this->displayError();
        return false;
    }

    public function filter()
    {
        $repository = $this->getRepository();

        list($filter, $sort, $curpage, $perpage) = $this->formatParameters();

        list($newsList, $count) = $repository->filter(
            $filter,
            $sort,
            ($curpage-1)*$perpage,
            $perpage
        );

        if ($count > 0) {
            $view = new NewsView($newsList);
            $view->pagination(
                'news',
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
