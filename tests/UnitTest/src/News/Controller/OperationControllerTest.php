<?php
namespace News\Controller;

use Prophecy\Argument;
use PHPUnit\Framework\TestCase;

use Marmot\Framework\Classes\Request;
use Marmot\Framework\Classes\Response;
use Marmot\Framework\Classes\CommandBus;

use News\Utils\ObjectGenerate;
use News\Repository\News\NewsRepository;
use News\Command\News\AddNewsCommand;
use News\Command\News\EditNewsCommand;

use WidgetRules\News\InputWidgetRules as NewsInputWidgetRules;
use WidgetRules\Common\InputWidgetRules as CommonInputWidgetRules;

class OperationControllerTest extends TestCase
{
    private $newsStub;

    private $faker;

    public function setUp()
    {
        $this->newsStub = $this->getMockBuilder(TestOperationController::class)
                        ->setMethods([
                            'getRequest',
                            'getResponse',
                            ])
                        ->getMock();

        $this->faker = \Faker\Factory::create('zh_CN');
    }

    public function teatDown()
    {
        unset($this->newsStub);
        unset($this->faker);
    }

    public function testGetRepository()
    {
        $this->assertInstanceOf(
            'News\Repository\News\NewsRepository',
            $this->newsStub->getRepository()
        );
    }

    public function testGetCommandBus()
    {
        $this->assertInstanceOf(
            'Marmot\Framework\Classes\CommandBus',
            $this->newsStub->getCommandBus()
        );
    }

    public function testGetCommonInputWidgetRules()
    {
        $this->assertInstanceOf(
            'WidgetRules\Common\InputWidgetRules',
            $this->newsStub->getCommonInputWidgetRules()
        );
    }

    public function testGetNewsInputWidgetRules()
    {
        $this->assertInstanceOf(
            'WidgetRules\News\InputWidgetRules',
            $this->newsStub->getNewsInputWidgetRules()
        );
    }

    private function initialAdd($result)
    {
        $this->newsStub = $this->getMockBuilder(TestOperationController::class)
                    ->setMethods([
                        'getRepository',
                        'getRequest',
                        'validateOperateScenario',
                        'validateAddScenario',
                        'getCommandBus',
                        'getResponse',
                        'render',
                        'displayError'
                    ])->getMock();

        $data = array(
            "type"=>"news",
            "attributes"=>array(
                "title"=>"最近睡眠不足,睡不够",
                "source"=>"明天想请假",
                "image"=>array('name'=>'图片名称', 'identify'=>'图片地址.jpg'),
                "attachments"=>array(
                    array('name' => 'name', 'identify' => 'identify.doc'),
                    array('name' => 'name', 'identify' => 'identify.doc'),
                ),
                "content"=>"下周要上课又是两天,要早上6点起,这周想双休",
            ),
            "relationships"=>array(
                "publishUserGroup"=>array(
                    "data"=>array(
                    array("type"=>"userGroups","id"=>3)
                    )
                )
            )
        );

        $attributes = $data['attributes'];
        $relationships = $data['relationships'];

        $title = $attributes['title'];
        $content = $attributes['content'];
        $source = $attributes['source'];
        $image = $attributes['image'];
        $attachments = $attributes['attachments'];

        $publishUserGroupId = $relationships['publishUserGroup']['data'][0]['id'];

        $request = $this->prophesize(Request::class);
        $request->post(Argument::exact('data'))
            ->shouldBeCalledTimes(1)
            ->willReturn($data);

        $this->newsStub->expects($this->exactly(1))
            ->method('getRequest')
            ->willReturn($request->reveal());
            
        $this->newsStub->expects($this->exactly(1))
            ->method('validateOperateScenario')
            ->with(
                $title,
                $source,
                $image,
                $attachments,
                $content
            )->willReturn(true);

        $this->newsStub->expects($this->exactly(1))
            ->method('validateAddScenario')
            ->with($publishUserGroupId)
            ->willReturn(true);

        $command = new AddNewsCommand(
            $title,
            $source,
            $image,
            $attachments,
            $content,
            $publishUserGroupId
        );

        $commandBus = $this->prophesize(CommandBus::class);
        $commandBus->send(Argument::exact($command))
                   ->shouldBeCalledTimes(1)
                   ->willReturn($result);
        $this->newsStub->expects($this->exactly(1))
             ->method('getCommandBus')
             ->willReturn($commandBus->reveal());

        return $command;
    }

    public function testAddSuccess()
    {
        $command = $this->initialAdd(true);

        $news = ObjectGenerate::generateNews($command->id);

        $repository = $this->prophesize(NewsRepository::class);
        $repository->fetchOne(Argument::exact($command->id))
                   ->shouldBeCalledTimes(1)
                   ->willReturn($news);
        $this->newsStub->expects($this->exactly(1))
             ->method('getRepository')
             ->willReturn($repository->reveal());

        $response = $this->prophesize(Response::class);
        $response->setStatusCode(Argument::exact(201))
                 ->shouldBeCalledTimes(1);
        $this->newsStub->expects($this->exactly(1))
             ->method('getResponse')
             ->willReturn($response->reveal());
             
        $this->newsStub->expects($this->exactly(1))
        ->method('render');

        $result = $this->newsStub->add();
        $this->assertTrue($result);
    }

    public function testAddFailure()
    {
        $this->initialAdd(false);

        $this->newsStub->expects($this->exactly(1))
             ->method('displayError');

        $result = $this->newsStub->add();
        $this->assertFalse($result);
    }

    private function initialEdit($result)
    {
        $this->newsStub = $this->getMockBuilder(TestOperationController::class)
                    ->setMethods([
                        'getRepository',
                        'getRequest',
                        'validateOperateScenario',
                        'getCommandBus',
                        'render',
                        'displayError'
                    ])->getMock();
                    
        $data = array(
            "type"=>"news",
            "attributes"=>array(
                "title"=>"最近睡眠不足,睡不够",
                "source"=>"明天想请假",
                "image"=>array('name'=>'图片名称', 'identify'=>'图片地址.jpg'),
                "attachments"=>array(
                    array('name' => 'name', 'identify' => 'identify.doc'),
                    array('name' => 'name', 'identify' => 'identify.doc'),
                ),
                "content"=>"下周要上课又是两天,要早上6点起,这周想双休",
            )
        );

        $attributes = $data['attributes'];

        $title = $attributes['title'];
        $content = $attributes['content'];
        $source = $attributes['source'];
        $image = $attributes['image'];
        $attachments = $attributes['attachments'];

        $id = $this->faker->randomDigit;
        
        $request = $this->prophesize(Request::class);
        $request->patch(Argument::exact('data'))
            ->shouldBeCalledTimes(1)
            ->willReturn($data);

        $this->newsStub->expects($this->exactly(1))
            ->method('getRequest')
            ->willReturn($request->reveal());

        $this->newsStub->expects($this->exactly(1))
            ->method('validateOperateScenario')
            ->with(
                $title,
                $source,
                $image,
                $attachments,
                $content
            )->willReturn(true);

        $command = new EditNewsCommand(
            $title,
            $source,
            $image,
            $attachments,
            $content,
            $id
        );

        $commandBus = $this->prophesize(CommandBus::class);
        $commandBus->send(Argument::exact($command))
                   ->shouldBeCalledTimes(1)
                   ->willReturn($result);
        $this->newsStub->expects($this->exactly(1))
             ->method('getCommandBus')
             ->willReturn($commandBus->reveal());
        
        return $command;
    }

    public function testEditSuccess()
    {
        $command = $this->initialEdit(true);

        $news = ObjectGenerate::generateNews($command->id);

        $repository = $this->prophesize(NewsRepository::class);
        $repository->fetchOne(Argument::exact($command->id))
                   ->shouldBeCalledTimes(1)
                   ->willReturn($news);
        $this->newsStub->expects($this->exactly(1))
             ->method('getRepository')
             ->willReturn($repository->reveal());
             
        $this->newsStub->expects($this->exactly(1))
        ->method('render');

        $result = $this->newsStub->edit($command->id);
        $this->assertTrue($result);
    }

    public function testEditFailure()
    {
        $command = $this->initialEdit(false);

        $this->newsStub->expects($this->exactly(1))
             ->method('displayError');

        $result = $this->newsStub->edit($command->id);
        $this->assertFalse($result);
    }
    
    /**
     * @dataProvider validateAddScenarioProvider
     */
    public function testValidateAddScenario($expect, $actual)
    {
        $this->newsStub = $this->getMockBuilder(TestOperationController::class)
                    ->setMethods(['getCommonInputWidgetRules'])
                    ->getMock();

        $publishUserGroupId = $this->faker->randomDigit;

        $commonInputWidgetRules = $this->prophesize(CommonInputWidgetRules::class);
    
        $commonInputWidgetRules->formatNumeric(
            Argument::exact($publishUserGroupId),
            Argument::exact('publishUserGroupId')
        )->shouldBeCalledTimes($expect['publishUserGroupIdCount'])->willReturn($expect['publishUserGroupId']);

        $this->newsStub->expects($this->any())
             ->method('getCommonInputWidgetRules')
             ->willReturn($commonInputWidgetRules->reveal());

        $result = $this->newsStub->validateAddScenario($publishUserGroupId);
        $this->assertEquals($actual, $result);
    }

    public function validateAddScenarioProvider()
    {
        return [
            [
                [
                    'publishUserGroupId'=>false, 'publishUserGroupIdCount'=>1
                ],
                false
            ],
            [
                [
                    'publishUserGroupId'=>true, 'publishUserGroupIdCount'=>1
                ],
                true
            ],
        ];
    }
    
    /**
     * @dataProvider validateOperateScenarioProvider
     */
    public function testValidateOperateScenario($expect, $actual)
    {
        $this->newsStub = $this->getMockBuilder(TestOperationController::class)
                    ->setMethods(['getCommonInputWidgetRules', 'getNewsInputWidgetRules'])
                    ->getMock();

        $title = $this->faker->title;
        $source = $this->faker->title;
        $image = array($this->faker->title);
        $attachments = array($this->faker->title);
        $content = $this->faker->title;

        $commonInputWidgetRules = $this->prophesize(CommonInputWidgetRules::class);
        $newsInputWidgetRules = $this->prophesize(NewsInputWidgetRules::class);
    
        $commonInputWidgetRules->title(Argument::exact($title))
                         ->shouldBeCalledTimes($expect['titleCount'])
                         ->willReturn($expect['title']);

        $newsInputWidgetRules->source(Argument::exact($source))
                         ->shouldBeCalledTimes($expect['sourceCount'])
                         ->willReturn($expect['source']);

        $commonInputWidgetRules->image(Argument::exact($image), Argument::exact('image'))
                         ->shouldBeCalledTimes($expect['imageCount'])
                         ->willReturn($expect['image']);

        $commonInputWidgetRules->attachments(Argument::exact($attachments), Argument::exact('attachments'))
                         ->shouldBeCalledTimes($expect['attachmentsCount'])
                         ->willReturn($expect['attachments']);

        $newsInputWidgetRules->content(Argument::exact($content))
                         ->shouldBeCalledTimes($expect['contentCount'])
                         ->willReturn($expect['content']);

        $this->newsStub->expects($this->any())
             ->method('getCommonInputWidgetRules')
             ->willReturn($commonInputWidgetRules->reveal());

        $this->newsStub->expects($this->any())
             ->method('getNewsInputWidgetRules')
             ->willReturn($newsInputWidgetRules->reveal());

        $result = $this->newsStub->validateOperateScenario(
            $title,
            $source,
            $image,
            $attachments,
            $content
        );
        $this->assertEquals($actual, $result);
    }

    public function validateOperateScenarioProvider()
    {
        return [
            [
                [
                    'title'=>false, 'titleCount'=>1,
                    'source'=>false, 'sourceCount'=>0,
                    'image'=>false, 'imageCount'=>0,
                    'attachments'=>false, 'attachmentsCount'=>0,
                    'content'=>false, 'contentCount'=>0,
                ],
                false
            ],
            [
                [
                    'title'=>true, 'titleCount'=>1,
                    'source'=>false, 'sourceCount'=>1,
                    'image'=>false, 'imageCount'=>0,
                    'attachments'=>false, 'attachmentsCount'=>0,
                    'content'=>false, 'contentCount'=>0,
                ],
                false
            ],
            [
                [
                    'title'=>true, 'titleCount'=>1,
                    'source'=>true, 'sourceCount'=>1,
                    'image'=>false, 'imageCount'=>1,
                    'attachments'=>false, 'attachmentsCount'=>0,
                    'content'=>false, 'contentCount'=>0,
                ],
                false
            ],
            [
                [
                    'title'=>true, 'titleCount'=>1,
                    'source'=>true, 'sourceCount'=>1,
                    'image'=>true, 'imageCount'=>1,
                    'attachments'=>false, 'attachmentsCount'=>1,
                    'content'=>false, 'contentCount'=>0,
                ],
                false
            ],
            [
                [
                    'title'=>true, 'titleCount'=>1,
                    'source'=>true, 'sourceCount'=>1,
                    'image'=>true, 'imageCount'=>1,
                    'attachments'=>true, 'attachmentsCount'=>1,
                    'content'=>false, 'contentCount'=>1,
                ],
                false
            ],
            [
                [
                    'title'=>true, 'titleCount'=>1,
                    'source'=>true, 'sourceCount'=>1,
                    'image'=>true, 'imageCount'=>1,
                    'attachments'=>true, 'attachmentsCount'=>1,
                    'content'=>true, 'contentCount'=>1,
                ],
                true
            ],
        ];
    }
}
