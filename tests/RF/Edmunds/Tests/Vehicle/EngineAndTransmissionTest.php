<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

class EngineAndTransmissionTest extends TestCase
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

    public function testGetEnginesByStyleId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/engine_holder.txt');
        $args = array('styleId' => '00000');
        $response = $this->client->getEnginesByStyleId($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['engines']));
        $this->assertTrue(is_array($response['engines'][0]));
        $this->assertEquals($response['engines'][0]['id'], '200477467');
    }

    public function testGetEngineById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/engine.txt');
        $args = array('id' => '11111');
        $response = $this->client->getEngineById($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['id'], '200477467');
    }

    public function testGetTransmissionsByStyleId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/transmission_holder.txt');
        $args = array('styleId' => '00000');
        $response = $this->client->getTransmissionsByStyleId($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['transmissions']));
        $this->assertTrue(is_array($response['transmissions'][0]));
        $this->assertEquals($response['transmissions'][0]['id'], '200477468');
    }

    public function testGetTransmissionById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/transmission.txt');
        $args = array('id' => '11111');
        $response = $this->client->getTransmissionById($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['id'], '200477468');
    }
}
