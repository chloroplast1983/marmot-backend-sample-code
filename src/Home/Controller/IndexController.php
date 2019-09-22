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
        echo "Hello World Backend Sample Code";
        return true;
    }
}
