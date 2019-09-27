<?php
namespace WidgetRules\News;

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
    
    //source -- start
    /**
     * @dataProvider invalidSourceProvider
     */
    public function testSource($actual, $expected)
    {
        $result = $this->stub->source($actual);

        if (!$expected) {
            $this->assertFalse($result);
            $this->assertEquals(NEWS_SOURCE_FORMAT_ERROR, Core::getLastError()->getId());
        }
        
        if ($expected) {
            $this->assertTrue($result);
        }
    }

    public function invalidSourceProvider()
    {
        $faker = \Faker\Factory::create('zh_CN');

        return array(
            array($faker->regexify(
                '[A-Za-z0-9.%+-]{'.WidgetRules::SOURCE_MIN_LENGTH.','.WidgetRules::SOURCE_MAX_LENGTH.'}'
            ), true),
            array($faker->regexify(
                '[A-Za-z0-9.%+-]{'.
                    (WidgetRules::SOURCE_MAX_LENGTH + 1 ).','.
                    (WidgetRules::SOURCE_MAX_LENGTH + 5 ).
                '}'
            ), false),
            array('', false),
            array($faker->randomDigit, false)
        );
    }

    //source -- end

    /**
     * @dataProvider contentProvider
     */
    public function testContent($actual, $expected)
    {
        $result = $this->stub->content($actual);

        if (!$expected) {
            $this->assertFalse($result);
            $this->assertEquals(NEWS_CONTENT_FORMAT_ERROR, Core::getLastError()->getId());
        }
        
        if ($expected) {
            $this->assertTrue($result);
        }
    }

    public function contentProvider()
    {
        $faker = \Faker\Factory::create('zh_CN');
        
        return array(
            array($faker->regexify(
                '[A-Za-z0-9.%+-]{'.WidgetRules::CONTENT_MIN_LENGTH.','.WidgetRules::CONTENT_MAX_LENGTH.'}'
            ), true),
            array($faker->regexify(
                '[A-Za-z0-9.%+-]{'.
                    (WidgetRules::CONTENT_MAX_LENGTH + 1 ).','.
                    (WidgetRules::CONTENT_MAX_LENGTH + 5 ).
                '}'
            ), false),
            array('', false)
        );
    }
}
