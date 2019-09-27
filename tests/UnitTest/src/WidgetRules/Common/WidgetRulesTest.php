<?php
namespace WidgetRules\Common;

use Marmot\Core;

use PHPUnit\Framework\TestCase;

/**
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */

class WidgetRulesTest extends TestCase
{
    private $stub;

    public function setUp()
    {
        $this->stub = new WidgetRules();
        Core::setLastError(ERROR_NOT_DEFINED);
    }

    public function tearDown()
    {
        unset($this->stub);
        Core::setLastError(ERROR_NOT_DEFINED);
    }
    
    //title -- start
    /**
     * @dataProvider invalidTitleProvider
     */
    public function testTitle($actual, $expected)
    {
        $result = $this->stub->title($actual);

        if (!$expected) {
            $this->assertFalse($result);
            $this->assertEquals(TITLE_FORMAT_ERROR, Core::getLastError()->getId());
        }
        
        if ($expected) {
            $this->assertTrue($result);
        }
    }

    public function invalidTitleProvider()
    {
        $faker = \Faker\Factory::create('zh_CN');

        return array(
            array($faker->regexify(
                '[A-Za-z0-9.%+-]{'.WidgetRules::TITLE_MIN_LENGTH.','.WidgetRules::TITLE_MAX_LENGTH.'}'
            ), true),
            array($faker->regexify(
                '[A-Za-z0-9.%+-]{'.
                    (WidgetRules::TITLE_MAX_LENGTH + 1 ).','.
                    (WidgetRules::TITLE_MAX_LENGTH + 5 ).
                '}'
            ), false),
            array('', false),
            array($faker->randomDigit, false)
        );
    }

    //title -- end
    /**
     * @dataProvider imageProvider
     */
    public function testImage($actual, $expected)
    {
        $result = $this->stub->image($actual);

        if (!$expected) {
            $this->assertFalse($result);
            $this->assertEquals(IMAGE_FORMAT_ERROR, Core::getLastError()->getId());
        }
        
        if ($expected) {
            $this->assertTrue($result);
        }
    }

    public function imageProvider()
    {
        $faker = \Faker\Factory::create('zh_CN');

        return array(
            array(['name'=>$faker->word, 'identify'=>'1.jpg'], true),
            array($faker->word, false),
            array(['name'=>$faker->word], false),
            array(['name'=>$faker->word, 'identify'=>$faker->word], false),
        );
    }

    /**
     * @dataProvider imagesProvider
     */
    public function testImages($actual, $expected)
    {
        $result = $this->stub->images($actual);

        if (!$expected) {
            $this->assertFalse($result);
            $this->assertEquals(IMAGE_FORMAT_ERROR, Core::getLastError()->getId());
        }
        
        if ($expected) {
            $this->assertTrue($result);
        }
    }

    public function imagesProvider()
    {
        $faker = \Faker\Factory::create('zh_CN');

        return array(
            array(
                [
                    ['name'=>$faker->word, 'identify'=>'1.jpg'],
                    ['name'=>$faker->word, 'identify'=>'1.jpg']
                ], true),
            array($faker->word, false),
            array(
                [
                    ['name'=>$faker->word, 'identify'=>$faker->word],
                    ['name'=>$faker->word, 'identify'=>$faker->word]
                ], false),
        );
    }

    /**
     * @dataProvider attachmentsProvider
     */
    public function testAttachments($actual, $expected)
    {
        $result = $this->stub->attachments($actual);

        if (!$expected) {
            $this->assertFalse($result);
            $this->assertEquals(ATTACHMENT_FORMAT_ERROR, Core::getLastError()->getId());
        }
        
        if ($expected) {
            $this->assertTrue($result);
        }
    }

    public function attachmentsProvider()
    {
        $faker = \Faker\Factory::create('zh_CN');
        
        return array(
            array(
                [
                    ['name'=>$faker->word,'identify'=>$faker->word.'.zip'],
                    ['name'=>$faker->word,'identify'=>$faker->word.'.doc'],
                    ['name'=>$faker->word,'identify'=>$faker->word.'.docx'],
                    ['name'=>$faker->word,'identify'=>$faker->word.'.xlsx'],
                    ['name'=>$faker->word,'identify'=>$faker->word.'.xls'],
                    ['name'=>$faker->word,'identify'=>$faker->word.'.pdf'],
                ], true),
            array($faker->word, false),
            array(
                [
                    ['name'=>$faker->word, 'identify'=>$faker->word],
                    ['name'=>$faker->word, 'identify'=>$faker->word]
                ], false),
        );
    }

    /**
     * @dataProvider formatNumericProvider
     */
    public function testFormatNumeric($actual, $expected, $pointer)
    {
        $result = $this->stub->formatNumeric($actual, $pointer);

        if (!$expected) {
            $this->assertFalse($result);
            $this->assertEquals(PARAMETER_FORMAT_ERROR, Core::getLastError()->getId());
            $this->assertEquals(array('pointer' => $pointer), Core::getLastError()->getSource());
        }
        
        if ($expected) {
            $this->assertTrue($result);
        }
    }

    public function formatNumericProvider()
    {
        $faker = \Faker\Factory::create('zh_CN');

        return array(
            array($faker->randomDigit, true, ''),
            array($faker->word, false, ''),
            array([], false, '')
        );
    }

    /**
     * @dataProvider formatStringProvider
     */
    public function testFormatString($actual, $expected, $pointer)
    {
        $result = $this->stub->formatString($actual, $pointer);

        if (!$expected) {
            $this->assertFalse($result);
            $this->assertEquals(PARAMETER_FORMAT_ERROR, Core::getLastError()->getId());
            $this->assertEquals(array('pointer' => $pointer), Core::getLastError()->getSource());
        }
        
        if ($expected) {
            $this->assertTrue($result);
        }
    }

    public function formatStringProvider()
    {
        $faker = \Faker\Factory::create('zh_CN');

        return array(
            array($faker->randomDigit, false, ''),
            array($faker->word, true, ''),
            array([], false, '')
        );
    }

    /**
     * @dataProvider formatArrayProvider
     */
    public function testFormatArray($actual, $expected, $pointer)
    {
        $result = $this->stub->formatArray($actual, $pointer);

        if (!$expected) {
            $this->assertFalse($result);
            $this->assertEquals(PARAMETER_FORMAT_ERROR, Core::getLastError()->getId());
            $this->assertEquals(array('pointer' => $pointer), Core::getLastError()->getSource());
        }
        
        if ($expected) {
            $this->assertTrue($result);
        }
    }

    public function formatArrayProvider()
    {
        $faker = \Faker\Factory::create('zh_CN');
        
        return array(
            array($faker->randomDigit, false, ''),
            array($faker->word, false, ''),
            array([], true, '')
        );
    }
}
