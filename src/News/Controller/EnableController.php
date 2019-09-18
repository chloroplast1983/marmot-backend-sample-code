<?php
namespace News\Controller;

use Marmot\Framework\Classes\CommandBus;
use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Controller\JsonApiTrait;

use Common\Controller\Interfaces\IEnableAbleController;

use News\Model\News;
use News\View\NewsView;
use News\Repository\News\NewsRepository;
use News\Command\News\EnableNewsCommand;
use News\Command\News\DisableNewsCommand;
use News\CommandHandler\News\NewsCommandHandlerFactory;

class EnableController extends Controller implements IEnableAbleController
{
    use JsonApiTrait;

    private $repository;
    
    private $commandBus;

    public function __construct()
    {
        parent::__construct();
        $this->repository = new NewsRepository();
        $this->commandBus = new CommandBus(new NewsCommandHandlerFactory());
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->repository);
        unset($this->commandBus);
    }

    protected function getRepository() : NewsRepository
    {
        return $this->repository;
    }

    protected function getCommandBus() : CommandBus
    {
        return $this->commandBus;
    }
    
    /**
     * 对应路由 /news/{id:\d+}/enable
     * 启用, 通过PATCH传参
     * @param int id 新闻id
     * @return jsonApi
     */
    public function enable(int $id)
    {
        if (!empty($id)) {
            $command = new EnableNewsCommand($id);

            if ($this->getCommandBus()->send($command)) {
                $news  = $this->getRepository()->fetchOne($id);
                if ($news instanceof News) {
                    $this->render(new NewsView($news));
                    return true;
                }
            }
        }
        $this->displayError();
        return false;
    }

    /**
     * 对应路由 /news/{id:\d+}/disable
     * 禁用, 通过PATCH传参
     * @param int id 新闻id
     * @return jsonApi
     */
    public function disable(int $id)
    {
        if (!empty($id)) {
            $command = new DisableNewsCommand($id);

            if ($this->getCommandBus()->send($command)) {
                $news  = $this->getRepository()->fetchOne($id);
                if ($news instanceof News) {
                    $this->render(new NewsView($news));
                    return true;
                }
            }
        }
        $this->displayError();
        return false;
    }
}
