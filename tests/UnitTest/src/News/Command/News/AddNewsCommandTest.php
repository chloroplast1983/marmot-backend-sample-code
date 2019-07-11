<?php
namespace News\Command\News;

use PHPUnit\Framework\TestCase;

class AddNewsCommandTest extends TestCase
{
    use OperationNewsTrait;
    
    private $fakerData = array();

    private $stub;

    public function setUp()
    {
        $faker = \Faker\Factory::create('zh_CN');
        $this->fakerData = array(
            'title' => $faker->title(),
            'source' => $faker->title(),
            'image' => array($faker->name()),
            'attachments' => array($faker->name()),
            'content' => $faker->text(),
            'publishUserGroupId' => $faker->randomNumber(),
            'id' => $faker->randomNumber(),
        );

        $this->stub = new AddNewsCommand(
            $this->fakerData['title'],
            $this->fakerData['source'],
            $this->fakerData['image'],
            $this->fakerData['attachments'],
            $this->fakerData['content'],
            $this->fakerData['publishUserGroupId'],
            $this->fakerData['id']
        );
    }

    public function testPublishUserGroupIdParameter()
    {
        $this->assertEquals($this->fakerData['publishUserGroupId'], $this->stub->publishUserGroupId);
    }
}
