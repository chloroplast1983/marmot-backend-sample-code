<?php
namespace News\Adapter\News;

use Common\Adapter\Document\DocumentAdapter;

class ContentDocumentAdapter extends DocumentAdapter
{
    const DBNAME = 'zhongjie';

    const COLLECTIONNAME = 'news_content';

    public function __construct()
    {
        parent::__construct(self::DBNAME, self::COLLECTIONNAME);
    }
}
