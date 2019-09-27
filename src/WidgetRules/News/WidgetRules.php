<?php
namespace WidgetRules\News;

use Respect\Validation\Validator as V;

use Marmot\Core;

use News\Model\News;

class WidgetRules
{
    const SOURCE_MIN_LENGTH = 2;
    const SOURCE_MAX_LENGTH = 15;

    public function source($source) : bool
    {
        if (!V::charset('UTF-8')->stringType()->notEmpty()->length(
            self::SOURCE_MIN_LENGTH,
            self::SOURCE_MAX_LENGTH
        )->validate($source)) {
            Core::setLastError(NEWS_SOURCE_FORMAT_ERROR, array('pointer'=>'source'));
            return false;
        }
        return true;
    }

    const CONTENT_MIN_LENGTH = 1;
    const CONTENT_MAX_LENGTH = 1000;

    public function content($content) : bool
    {
        if (!V::charset('UTF-8')->stringType()->notEmpty()->length(
            self::CONTENT_MIN_LENGTH,
            self::CONTENT_MAX_LENGTH
        )->validate(htmlspecialchars($content))) {
            Core::setLastError(NEWS_CONTENT_FORMAT_ERROR);
            return false;
        }

        return true;
    }
}
