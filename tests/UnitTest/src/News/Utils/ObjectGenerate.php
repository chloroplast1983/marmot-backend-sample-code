<?php
namespace News\Utils;

use News\Model\News;
use News\Model\ContentDocument;

use Common\Model\IEnableAble;

class ObjectGenerate
{
    public static function generateNews(
        int $id = 0,
        int $seed = 0,
        array $value = array()
    ) : News {
        $faker = \Faker\Factory::create('zh_CN');
        $faker->seed($seed);

        $news = new News($id);

        $news->setId($id);

        //title
        $title = isset($value['title']) ? $value['title'] : $faker->word();
        $news->setTitle($title);

        //source
        $source = isset($value['source']) ? $value['source'] : $faker->word();
        $news->setSource($source);

        //image
        $image = isset($value['image']) ? $value['image'] : array($faker->word());
        $news->setImage($image);

        //attachments
        $attachments = isset($value['attachments']) ? $value['attachments'] : array($faker->word());
        $news->setAttachments($attachments);

        //content
        self::generateContent($news, $faker);
 
        //userGroup
        self::generateUserGroup($news, $faker);
        
        //status
        $status = isset($value['status'])
        ? $value['status']
        : $faker->randomElement(IEnableAble::STATUS);
        $news->setStatus($status);

        $news->setCreateTime($faker->unixTime());
        $news->setUpdateTime($faker->unixTime());
        $news->setStatusTime($faker->unixTime());

        return $news;
    }

    private static function generateContent($object, $faker) : void
    {
        $content = $faker->text();

        $contentDocument = new ContentDocument();
        $contentDocument->setData(array('content'=> $content));

        $object->setContent($contentDocument);
    }

    private static function generateUserGroup($object, $faker) : void
    {
        $userGroup = \UserGroup\Utils\ObjectGenerate::generateUserGroup($faker->numerify());
        $object->setPublishUserGroup($userGroup);
    }
}
