<?php
namespace Home\Controller;

use Marmot\Framework\Classes\Controller;
use Marmot\Framework\Controller\JsonApiTrait;

class IndexController extends Controller
{
    use JsonApiTrait;

    /**
     * @codeCoverageIgnore
     */
    public function index()
    {
        var_dump("Hello World Backend Sample Code");
        return true;
    }
}
