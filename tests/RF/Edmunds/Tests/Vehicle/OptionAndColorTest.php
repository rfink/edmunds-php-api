<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

class OptionAndColorTest extends TestCase
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

    public function testGetOptionsByStyleId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/option_holder.txt');
        $args = array('styleId' => '00000');
        $response = $this->client->getOptionsByStyleId($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['options']));
        $this->assertTrue(is_array($response['options'][0]));
        $this->assertTrue(is_array($response['options'][0]['price']));
        $this->assertEquals($response['options'][0]['id'], '200477509');
    }

    public function testGetOptionById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/option.txt');
        $args = array('id' => '11111');
        $response = $this->client->getOptionDetailsById($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['price']));
        $this->assertEquals($response['id'], '200477503');
    }

    public function testGetColorsByStyleId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/color_holder.txt');
        $args = array('styleId' => '00000');
        $response = $this->client->getColorsByStyleId($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['colors']));
        $this->assertTrue(is_array($response['colors'][0]));
        $this->assertEquals($response['colors'][0]['id'], '200477485');
        $this->assertTrue(is_array($response['colors'][0]['colorChips']));
        $this->assertTrue(is_array($response['colors'][0]['colorChips']['primary']));
    }

    public function testGetColorById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/color.txt');
        $args = array('id' => '11111');
        $response = $this->client->getColorDetailsById($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['id'], '200477485');
        $this->assertTrue(is_array($response['colorChips']));
        $this->assertTrue(is_array($response['colorChips']['primary']));
    }
}
