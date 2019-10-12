<?php
namespace Common\View;

use Marmot\Interfaces\IView;

/**
 * @SuppressWarnings(PHPMD)
 */
abstract class CommonView implements IView
{
    use JsonApiView;

    private $rules;

    private $data;
    
    private $encodingParameters;

    public function __construct($data, $encodingParameters = null)
    {
        $this->data = $data;
        $this->encodingParameters = $encodingParameters;

        $this->rules = array(
            \News\Model\News::class => \News\View\NewsSchema::class,
            \News\Model\NullNews::class => \News\View\NewsSchema::class,
            
            \UserGroup\Model\UserGroup::class => \UserGroup\View\UserGroupSchema::class,
            \UserGroup\Model\NullUserGroup::class => \UserGroup\View\UserGroupSchema::class,

            \Member\Model\Member::class => \Member\View\MemberSchema::class,
            \Member\Model\NullMember::class => \Member\View\MemberSchema::class,
        );
    }
    
    public function display()
    {
        return $this->jsonApiFormat($this->data, $this->rules, $this->encodingParameters);
    }
}
