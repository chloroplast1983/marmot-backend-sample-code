<?php
namespace WidgetRules\Member;

use Respect\Validation\Validator as V;

use Marmot\Core;

class WidgetRules
{
    public function password($password) : bool
    {
        $reg = '/(?=.*[a-z])(?=.*[0-9])[A-Za-z0-9]{6,18}/';
        if (!V::alnum()->noWhitespace()->length(6, 30)->validate($password) || !preg_match($reg, $password)) {
            Core::setLastError(PASSWORD_FORMAT_ERROR);
            return false;
        }

        return true;
    }
}
