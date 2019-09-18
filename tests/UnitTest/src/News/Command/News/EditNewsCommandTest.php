<?php
namespace News\Command\News;

use PHPUnit\Framework\TestCase;

class EditNewsCommandTest extends TestCase
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
            'id' => $faker->randomNumber(),
        );

        $this->stub = new EditNewsCommand(
            $this->fakerData['title'],
            $this->fakerData['source'],
            $this->fakerData['image'],
            $this->fakerData['attachments'],
            $this->fakerData['content'],
            $this->fakerData['id']
        );
    }
}
