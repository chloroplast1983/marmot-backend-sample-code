<?php
namespace News\Controller;

use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Classes\CommandBus;
use Marmot\Framework\Controller\JsonApiTrait;

use Common\Controller\Interfaces\IOperatAbleController;

use News\Model\News;
use News\View\NewsView;
use News\Command\News\AddNewsCommand;
use News\Command\News\EditNewsCommand;
use News\Repository\News\NewsRepository;
use News\CommandHandler\News\NewsCommandHandlerFactory;

use WidgetRules\News\InputWidgetRules as NewsInputWidgetRules;
use WidgetRules\Common\InputWidgetRules as CommonInputWidgetRules;

class OperationController extends Controller implements IOperatAbleController
{
    use JsonApiTrait;

    private $commonInputWidgetRules;

    private $newsInputWidgetRules;

    private $repository;

    private $commandBus;
    
    public function __construct()
    {
        parent::__construct();
        $this->commonInputWidgetRules = new CommonInputWidgetRules();
        $this->newsInputWidgetRules = new NewsInputWidgetRules();
        $this->repository = new NewsRepository();
        $this->commandBus = new CommandBus(new NewsCommandHandlerFactory());
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->commonInputWidgetRules);
        unset($this->newsInputWidgetRules);
        unset($this->repository);
        unset($this->commandBus);
    }

    protected function getCommonInputWidgetRules() : CommonInputWidgetRules
    {
        return $this->commonInputWidgetRules;
    }

    protected function getNewsInputWidgetRules() : NewsInputWidgetRules
    {
        return $this->newsInputWidgetRules;
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
     * 对应路由 /news
     * 新闻新增功能, 通过POST传参
     * @param jsonApi
     * @return jsonApi
     */
    public function add()
    {
        $data = $this->getRequest()->post('data');
        $attributes = $data['attributes'];
        $relationships = $data['relationships'];

        $title = $attributes['title'];
        $source = $attributes['source'];
        $image = $attributes['image'];
        $attachments = $attributes['attachments'];
        $content = $attributes['content'];
        $publishUserGroupId = $relationships['publishUserGroup']['data'][0]['id'];

        if ($this->validateOperateScenario(
            $title,
            $source,
            $image,
            $attachments,
            $content
        ) && $this->validateAddScenario($publishUserGroupId)) {
            $commandBus = $this->getCommandBus();

            $command = new AddNewsCommand(
                $title,
                $source,
                $image,
                $attachments,
                $content,
                $publishUserGroupId
            );

            if ($commandBus->send($command)) {
                $repository = $this->getRepository();
                $news = $repository->fetchOne($command->id);
                if ($news instanceof News) {
                    $this->getResponse()->setStatusCode(201);
                    $this->render(new NewsView($news));
                    return true;
                }
            }
        }

        $this->displayError();
        return false;
    }

    protected function validateAddScenario(
        $publishUserGroupId
    ) : bool {
        return $this->getCommonInputWidgetRules()->formatNumeric($publishUserGroupId, 'publishUserGroupId');
    }
    /**
     * /news/{id:\d+}
     * 新闻编辑功能, 通过PATCH传参
     * @param jsonApi
     * @return jsonApi
     */
    public function edit(int $id)
    {
        $data = $this->getRequest()->patch('data');
        $attributes = $data['attributes'];
        
        $title = $attributes['title'];
        $source = $attributes['source'];
        $image = $attributes['image'];
        $attachments = $attributes['attachments'];
        $content = $attributes['content'];

        if ($this->validateOperateScenario(
            $title,
            $source,
            $image,
            $attachments,
            $content
        )) {
            $commandBus = $this->getCommandBus();

            $command = new EditNewsCommand(
                $title,
                $source,
                $image,
                $attachments,
                $content,
                $id
            );

            if ($commandBus->send($command)) {
                $repository = $this->getRepository();
                $news = $repository->fetchOne($id);
                if ($news instanceof News) {
                    $this->render(new NewsView($news));
                    return true;
                }
            }
        }

        $this->displayError();
        return false;
    }
    
    protected function validateOperateScenario(
        $title,
        $source,
        $image,
        $attachments,
        $content
    ) : bool {
        return $this->getCommonInputWidgetRules()->title($title)
            && $this->getNewsInputWidgetRules()->source($source)
            && (empty($image) ? true : $this->getCommonInputWidgetRules()->image($image, 'image'))
            && $this->getCommonInputWidgetRules()->attachments($attachments, 'attachments')
            && $this->getNewsInputWidgetRules()->content($content);
    }
}
