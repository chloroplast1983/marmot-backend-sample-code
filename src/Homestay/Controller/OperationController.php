<?php
namespace Homestay\Controller;

use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Classes\CommandBus;
use Marmot\Framework\Controller\JsonApiTrait;

use Common\Controller\Interfaces\IOperatAbleController;

use Homestay\Model\Homestay;
use Homestay\View\HomestayView;
use Homestay\Command\Homestay\AddCommand;
use Homestay\Command\Homestay\EditCommand;
use Homestay\Repository\Homestay\HomestayRepository;
use Homestay\CommandHandler\Homestay\HomestayCommandHandlerFactory;

use WidgetRules\Common\WidgetRules as CommonWidgetRules;

class OperationController extends Controller implements IOperatAbleController
{
    use JsonApiTrait;

    private $commonWidgetRules;

    private $repository;

    private $commandBus;
    
    public function __construct()
    {
        parent::__construct();
        $this->commonWidgetRules = new CommonWidgetRules();
        $this->repository = new HomestayRepository();
        $this->commandBus = new CommandBus(new HomestayCommandHandlerFactory());
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->commonWidgetRules);
        unset($this->repository);
        unset($this->commandBus);
    }

    protected function getCommonWidgetRules() : CommonWidgetRules
    {
        return $this->commonWidgetRules;
    }

    protected function getRepository() : HomestayRepository
    {
        return $this->repository;
    }

    protected function getCommandBus() : CommandBus
    {
        return $this->commandBus;
    }

    /**
     * 对应路由 /homestaies
     * 民宿新增功能, 通过POST传参
     * @param jsonApi
     * @return jsonApi
     */
    public function add()
    {
        $data = $this->getRequest()->post('data');
        $attributes = $data['attributes'];

        $name = $attributes['name'];
        $logo = $attributes['logo'];

        if ($this->validateOperateScenario(
            $name,
            $logo
        )) {
            $commandBus = $this->getCommandBus();

            $command = new AddCommand(
                $name,
                $logo
            );

            if ($commandBus->send($command)) {
                $repository = $this->getRepository();
                $homestay = $repository->fetchOne($command->id);

                if ($homestay instanceof Homestay) {
                    $this->getResponse()->setStatusCode(201);
                    $this->render(new HomestayView($homestay));
                    return true;
                }
            }
        }

        $this->displayError();
        return false;
    }

    /**
     * /homestay/{id:\d+}
     * 编辑功能, 通过PATCH传参
     * @param jsonApi
     * @return jsonApi
     */
    public function edit(int $id)
    {        
        $data = $this->getRequest()->patch('data');
        $attributes = $data['attributes'];

        $name = $attributes['name'];
        $logo = $attributes['logo'];

        if ($this->validateOperateScenario(
            $name,
            $logo
        )) {
            $commandBus = $this->getCommandBus();

            $command = new EditCommand(
                $name,
                $logo,
                $id
            );

            if ($commandBus->send($command)) {
                $repository = $this->getRepository();
                $homestay = $repository->fetchOne($command->id);

                if ($homestay instanceof Homestay) {
                    $this->render(new HomestayView($homestay));
                    return true;
                }
            }
        }

        $this->displayError();
        return false;
    }
    
    protected function validateOperateScenario(
        $name,
        $logo
    ) : bool {
        return $this->getCommonWidgetRules()->name($name)
            && $this->getCommonWidgetRules()->image($logo, 'logo');
    }
}
