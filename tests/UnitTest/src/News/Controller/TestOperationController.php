<?php
namespace News\Controller;

use Marmot\Framework\Classes\CommandBus;

use News\Repository\News\NewsRepository;

use WidgetRules\News\InputWidgetRules as NewsInputWidgetRules;
use WidgetRules\Common\InputWidgetRules as CommonInputWidgetRules;

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

    public function getCommonInputWidgetRules() : CommonInputWidgetRules
    {
        return parent::getCommonInputWidgetRules();
    }

    public function getNewsInputWidgetRules() : NewsInputWidgetRules
    {
        return parent::getNewsInputWidgetRules();
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
