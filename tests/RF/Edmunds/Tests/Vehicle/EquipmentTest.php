<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

class EquipmentTest extends TestCase
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

    public function testGetEquipmentDetailsByStyleId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/equipment_holder.txt');
        $args = array('styleId' => '0000000');
        $response = $this->client->getEquipmentDetailsByStyleId($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['equipment']));
        $this->assertTrue(is_array($response['equipment'][0]));
        $this->assertEquals($response['equipment'][0]['id'], '20047746515');
        $this->assertTrue(is_array($response['equipment'][0]['attributes']));
    }

    public function testGetEquipmentDetailsById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/equipment.txt');
        $args = array('id' => '200477520');
        $response = $this->client->getEquipmentDetailsById($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['id'], '200477520');
        $this->assertTrue(is_array($response['attributes']));
    }
}
