<?php

namespace RF\Edmunds\Tests\Dealer;

use RF\Edmunds\Dealer\Client;
use RF\Edmunds\Tests\TestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class RepairShopTest extends TestCase
{
    public function setUp()
    {
        $this->client = Client::factory(array(
            'api_key' => 'API KEY GOES HERE',
            'baseUrl' => 'http://api.edmunds.com'
        ));
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->client = null;
    }

    public function testGetRepairShopById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/repairshop.txt');
        $args = array('id' => '11111');
        $response = $this->client->getRepairShopById($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['dealerId'], '839025');
        $this->assertEquals($response['repairshopId'], '839031');
        $this->assertEquals($response['type'], 'REPAIRSHOP');
        $this->assertTrue(is_array($response['operations']));
        $this->assertTrue(is_array($response['address']));
        $this->assertTrue(is_array($response['make']));
    }

    public function testGetRepairShops()
    {
        $this->setMockResponse(__DIR__ . '/mocks/repairshop_holder.txt');
        $args = array('zipcode' => '90210');
        $response = $this->client->getRepairShops($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['repairshops']));
        $this->assertTrue(is_array($response['repairshops'][0]));
        $this->assertEquals($response['repairshops'][0]['dealerId'], '879');
        $this->assertEquals($response['repairshops'][0]['active'], true);
        $this->assertEquals($response['repairshops'][0]['repairshopId'], '72251');
        $this->assertTrue(is_array($response['repairshops'][0]['operations']));
        $this->assertTrue(is_array($response['repairshops'][0]['address']));
        $this->assertTrue(is_array($response['repairshops'][0]['make']));
    }

    public function testGetRepairShopsCount()
    {
        $this->setMockResponse(__DIR__ . '/mocks/repairshop_count.txt');
        $args = array('zipcode' => '90210');
        $response = $this->client->getRepairShopsCount($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['repairshopsCount'], 19);
    }
}
