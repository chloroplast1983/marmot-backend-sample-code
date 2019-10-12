<?php
namespace WidgetRules\Common;

use Respect\Validation\Validator as V;

use Marmot\Core;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class WidgetRules
{
    const TITLE_MIN_LENGTH = 6;
    const TITLE_MAX_LENGTH = 150;

    public function title($title) : bool
    {
        if (!V::charset('UTF-8')->stringType()->length(
            self::TITLE_MIN_LENGTH,
            self::TITLE_MAX_LENGTH
        )->validate($title)) {
            Core::setLastError(TITLE_FORMAT_ERROR, array('pointer'=>'title'));
            return false;
        }

        return true;
    }

    public function image($image, $pointer = 'image') : bool
    {
        if (!V::arrayType()->validate($image)) {
            Core::setLastError(IMAGE_FORMAT_ERROR, array('pointer'=>$pointer));
            return false;
        }

        if (!isset($image['identify']) || !$this->validateImageExtension($image['identify'])) {
            Core::setLastError(IMAGE_FORMAT_ERROR, array('pointer'=>$pointer));
            return false;
        }

        return true;
    }

    public function images($images, $pointer = 'image') : bool
    {
        if (!V::arrayType()->validate($images)) {
            Core::setLastError(IMAGE_FORMAT_ERROR, array('pointer'=>$pointer));
            return false;
        }

        foreach ($images as $image) {
            if (!$this->validateImageExtension($image['identify'])) {
                Core::setLastError(IMAGE_FORMAT_ERROR, array('pointer'=>$pointer));
                return false;
            }
        }
        return true;
    }

    private function validateImageExtension($image) : bool
    {
        if (!V::extension('png')->validate($image)
            && !V::extension('jpg')->validate($image)
            && !V::extension('jpeg')->validate($image)) {
            return false;
        }

        return true;
    }

    public function attachments($attachments) : bool
    {
        if (!V::arrayType()->validate($attachments)) {
            Core::setLastError(ATTACHMENT_FORMAT_ERROR);
            return false;
        }

        foreach ($attachments as $attachment) {
            if (!$this->validateAttachmentExtension($attachment['identify'])) {
                Core::setLastError(ATTACHMENT_FORMAT_ERROR);
                return false;
            }
        }
        
        return true;
    }

    private function validateAttachmentExtension(string $attachment) : bool
    {
        if (!V::extension('zip')->validate($attachment)
            && !V::extension('doc')->validate($attachment)
            && !V::extension('docx')->validate($attachment)
            && !V::extension('xls')->validate($attachment)
            && !V::extension('xlsx')->validate($attachment)
            && !V::extension('pdf')->validate($attachment)
        ) {
            return false;
        }

        return true;
    }

    const REAL_NAME_MIN_LENGTH = 2;
    const REAL_NAME_MAX_LENGTH = 20;

    public function realName($realName) : bool
    {
        if (!V::charset('UTF-8')->stringType()->length(
            self::REAL_NAME_MIN_LENGTH,
            self::REAL_NAME_MAX_LENGTH
        )->validate($realName)) {
            Core::setLastError(REAL_NAME_FORMAT_ERROR);
            return false;
        }

        return true;
    }

    public function cellphone($cellphone) : bool
    {
        $reg = '/^[1][0-9]{10}$/';
        if (!preg_match($reg, $cellphone)) {
            Core::setLastError(CELLPHONE_FORMAT_ERROR);
            return false;
        }

        return true;
    }

    public function price($price) : bool
    {
        $reg = '/^(?!.{12,}$)\d+(\.\d{1,2})?$/';

        if (!V::FloatVal()->notEmpty()->validate($price) || !preg_match($reg, $price)) {
            Core::setLastError(PRICE_FORMAT_ERROR);
            return false;
        }
        
        return true;
    }

    public function cardId($cardId) : bool
    {
        if (!V::alnum()->noWhitespace()->length(15, 15)->validate($cardId)
            && !V::alnum()->noWhitespace()->length(18, 18)->validate($cardId)) {
            Core::setLastError(USER_CARDID_FORMAT_ERROR);
            return false;
        }

        return true;
    }

    public function date($date, $pointer = 'date') : bool
    {
        if (date('Y-m-d', strtotime($date)) != $date) {
            Core::setLastError(DATE_FORMAT_ERROR, array('pointer'=>$pointer));
            return false;
        }

        return true;
    }

    const NAME_MIN_LENGTH = 2;
    const NAME_MAX_LENGTH = 20;

    public function name($name) : bool
    {
        if (!V::charset('UTF-8')->stringType()->length(
            self::NAME_MIN_LENGTH,
            self::NAME_MAX_LENGTH
        )->validate($name)) {
            Core::setLastError(NAME_FORMAT_ERROR, array('pointer'=>'name'));
            return false;
        }

        return true;
    }

    public function url($url, $pointer = 'url') : bool
    {
        if (!V::url()->validate($url)) {
            Core::setLastError(URL_FORMAT_ERROR, array('pointer'=>$pointer));
            return false;
        }

        return true;
    }

    public function formatNumeric($data, string $pointer = '') : bool
    {
        if (is_numeric($data)) {
            return true;
        }
        Core::setLastError(PARAMETER_FORMAT_ERROR, array('pointer'=>$pointer));
        return false;
    }

    public function formatString($data, string $pointer = '') : bool
    {
        if (is_string($data)) {
            return true;
        }
        Core::setLastError(PARAMETER_FORMAT_ERROR, array('pointer'=>$pointer));
        return false;
    }

    public function formatArray($data, string $pointer = '') : bool
    {
        if (is_array($data)) {
            return true;
        }
        Core::setLastError(PARAMETER_FORMAT_ERROR, array('pointer'=>$pointer));
        return false;
    }
}
