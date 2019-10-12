<?php
namespace Member\Controller;

use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Classes\CommandBus;
use Marmot\Framework\Controller\JsonApiTrait;

use Common\Controller\Interfaces\IOperatAbleController;

use Member\Model\Member;
use Member\View\MemberView;
use Member\Command\Member\SignUpMemberCommand;
use Member\Command\Member\SignInMemberCommand;
use Member\Repository\Member\MemberRepository;
use Member\CommandHandler\Member\MemberCommandHandlerFactory;

use WidgetRules\Member\WidgetRules as MemberWidgetRules;
use WidgetRules\Common\WidgetRules as CommonWidgetRules;

class OperationController extends Controller implements IOperatAbleController
{
    use JsonApiTrait;

    private $commonWidgetRules;

    private $memberWidgetRules;

    private $repository;

    private $commandBus;
    
    public function __construct()
    {
        parent::__construct();
        $this->commonWidgetRules = new CommonWidgetRules();
        $this->memberWidgetRules = new MemberWidgetRules();
        $this->repository = new MemberRepository();
        $this->commandBus = new CommandBus(new MemberCommandHandlerFactory());
    }

    public function __destruct()
    {
        parent::__destruct();
        unset($this->commonWidgetRules);
        unset($this->memberWidgetRules);
        unset($this->repository);
        unset($this->commandBus);
    }

    protected function getCommonWidgetRules() : CommonWidgetRules
    {
        return $this->commonWidgetRules;
    }

    protected function getMemberWidgetRules() : MemberWidgetRules
    {
        return $this->memberWidgetRules;
    }

    protected function getRepository() : MemberRepository
    {
        return $this->repository;
    }

    protected function getCommandBus() : CommandBus
    {
        return $this->commandBus;
    }

    /**
     * 对应路由 /member/signIn
     * 登录功能, 通过POST传参
     * @param jsonApi
     * @return jsonApi
     */
    public function signIn()
    {
        $data = $this->getRequest()->post('data');
        $attributes = $data['attributes'];

        $passport = $attributes['passport'];
        $password = $attributes['password'];

        if ($this->validateSignInScenario(
            $passport,
            $password
        )) {
            $command = new SignInMemberCommand(
                $passport,
                $password
            );

            if ($this->getCommandBus()->send($command)) {
                $repository = $this->getRepository();
                $member = $repository->fetchOne($command->id);
                if ($member instanceof Member) {
                    $this->getResponse()->setStatusCode(201);
                    $this->render(new MemberView($member));
                    return true;
                }
            }
        }

        $this->displayError();
        return false;
    }

    protected function validateSignInScenario(
        $passport,
        $password
    ) : bool {
        return $this->getCommonWidgetRules()->cellphone($passport)
        && $this->getMemberWidgetRules()->password($password);
    }

    /**
     * /member/signUp
     * 注册功能, 通过POST传参
     * @param jsonApi
     * @return jsonApi
     */
    public function signUp()
    {
        $data = $this->getRequest()->post('data');
        $attributes = $data['attributes'];
        
        $cellphone = $attributes['cellphone'];
        $password = $attributes['password'];

        if ($this->validateSignUpScenario(
            $cellphone,
            $password
        )) {
            $command = new SignUpMemberCommand(
                $cellphone,
                $password
            );

            if ($this->getCommandBus()->send($command)) {
                $repository = $this->getRepository();
                $member = $repository->fetchOne($command->id);
                if ($member instanceof Member) {
                    $this->render(new MemberView($member));
                    return true;
                }
            }
        }

        $this->displayError();
        return false;
    }
    
    protected function validateSignUpScenario(
        $passport,
        $password
    ) : bool {
        return $this->getCommonWidgetRules()->cellphone($passport)
        && $this->getMemberWidgetRules()->password($password);
    }

    public function add()
    {
        $this->displayError();
        return false;
    }

    public function edit(int $id)
    {
        $this->displayError();
        return false;
    }
}
