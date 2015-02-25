<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class StyleRepositoryTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->client = Client::factory(array(
            'api_key' => 'API KEY GOES HERE',
            'baseUrl' => 'http://api.edmunds.com'
        ));
    }

    public function tearDown()
    {
        $this->client = null;
        parent::tearDown();
    }

    public function testGetStyleById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/style.txt');
        $args = array('id' => '101200938');
        $response = $this->client->getStyleById($args);
        $this->assertStyleData($response);
    }

    public function testGetStylesByMakeAndModelAndYear()
    {
        $this->setMockResponse(__DIR__ . '/mocks/style_holder.txt');
        $args = array('makeNiceName' => 'honda', 'modelNiceName' => 'pilot', 'year' => '2013');
        $response = $this->client->getStylesByMakeAndModelAndYear($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['styles']));
        $this->assertStyleData($response['styles'][0]);
    }

    public function testGetStylesCountByMakeAndModelAndYear()
    {
        $this->setMockResponse(__DIR__ . '/mocks/style_count.txt');
        $args = array('makeNiceName' => 'honda', 'modelNiceName' => 'pilot', 'year' => '2013');
        $response = $this->client->getStylesCountByMakeAndModelAndYear($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['stylesCount'], 45318);
    }

    public function testGetStylesCountByMakeAndModel()
    {
        $this->setMockResponse(__DIR__ . '/mocks/style_count.txt');
        $args = array('makeNiceName' => 'honda', 'modelNiceName' => 'pilot');
        $response = $this->client->getStylesCountByMakeAndModel($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['stylesCount'], 45318);
    }

    public function testGetStylesCountByMake()
    {
        $this->setMockResponse(__DIR__ . '/mocks/style_count.txt');
        $args = array('makeNiceName' => 'honda');
        $response = $this->client->getStylesCountByMake($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['stylesCount'], 45318);
    }

    public function testGetStylesCount()
    {
        $this->setMockResponse(__DIR__ . '/mocks/style_count.txt');
        $args = array('makeNiceName' => 'honda');
        $response = $this->client->getStylesCount($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['stylesCount'], 45318);
    }

    public function testGetStyleByChromeId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/style.txt');
        $args = array('chromeId' => '00000');
        $response = $this->client->getStyleByChromeId($args);
        $this->assertStyleData($response);
    }

    private function assertStyleData($response)
    {
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['make']));
        $this->assertEquals($response['make']['id'], '200001444');
        $this->assertTrue(is_array($response['model']));
        $this->assertTrue(is_array($response['engine']));
        $this->assertTrue(is_array($response['transmission']));
        $this->assertTrue(is_array($response['colors']));
        $this->assertTrue(is_array($response['colors'][0]));
        $this->assertTrue(is_array($response['price']));
        $this->assertTrue(is_array($response['categories']));
        $this->assertTrue(is_array($response['year']));
        $this->assertTrue(is_array($response['submodel']));
        $this->assertTrue(is_array($response['MPG']));
        $this->assertTrue(is_array($response['states']));
        $this->assertTrue(is_array($response['squishVins']));
    }
}
