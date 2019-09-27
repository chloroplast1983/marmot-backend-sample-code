<?php
namespace News\Controller;

use Marmot\Framework\Classes\CommandBus;

use News\Repository\News\NewsRepository;

use WidgetRules\News\WidgetRules as NewsWidgetRules;
use WidgetRules\Common\WidgetRules as CommonWidgetRules;

class TestOperationController extends OperationController
{
    public function getRepository() : NewsRepository
    {
        return parent::getRepository();
    }

    public function getCommandBus() : CommandBus
    {
        return parent::getCommandBus();
    }

    public function getCommonWidgetRules() : CommonWidgetRules
    {
        return parent::getCommonWidgetRules();
    }

    public function getNewsWidgetRules() : NewsWidgetRules
    {
        return parent::getNewsWidgetRules();
    }

    public function validateAddScenario(
        $publishUserGroupId
    ) : bool {
        return parent::validateAddScenario(
            $publishUserGroupId
        );
    }

    public function validateOperateScenario(
        $title,
        $source,
        $image,
        $attachments,
        $content
    ) : bool {
        return parent::validateOperateScenario(
            $title,
            $source,
            $image,
            $attachments,
            $content
        );
    }
}
