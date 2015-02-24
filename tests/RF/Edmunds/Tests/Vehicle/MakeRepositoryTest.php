<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class MakeRepositoryTest extends TestCase
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
    
    public function testVinDecoder()
    {
        $this->setMockResponse(__DIR__ . '/mocks/vin_decoder.txt');
        $args = ['vin' => '2G1FC3D33C9165616'];
        $response = $this->client->decodeVin($args);
        $this->assertVinDecoded($response);
    }

    public function testSquishVins()
    {
        $this->setMockResponse(__DIR__ . '/mocks/vin_decoder.txt');
        $args = ['squishVin' => '2G1FC3D33'];
        $response = $this->client->getDetailsBySquishVin($args);
        $this->assertVinDecoded($response);
    }

    public function testVinConfiguration()
    {
        $this->setMockResponse(__DIR__ . '/mocks/vin_configuration.txt');
        $args = ['vin' => '2G1FC3D33C9165616'];
        $response = $this->client->getVinConfiguration($args);
        $this->assertArrayHasKey('link', $response);
        $this->assertEquals($response['year'], 2012);
        $this->assertArrayHasKey('make', $response);
        $this->assertArrayHasKey('model', $response);
        $this->assertEquals($response['vehicleStyle'], 'Convertible');
        $this->assertEquals($response['drivenWheels'], 'rear wheel drive');
        $this->assertEquals($response['fuelType'], 'gas');
        $this->assertArrayHasKey('trim', $response);
        $this->assertEquals($response['cylinders'], 6);
        $this->assertArrayHasKey('styles', $response);
    }

    public function testGetAll()
    {
        $this->setMockResponse(__DIR__ . '/mocks/makes.txt');
        $response = $this->client->getAllMakes();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['makes']));
        $this->assertEquals(count($response['makes']), 2);
        $this->assertEquals($response['makes'][0]['id'], 200002305);
        $this->assertEquals($response['makes'][0]['name'], 'MINI');
        $this->assertEquals($response['makes'][0]['niceName'], 'mini');
        $this->assertTrue(is_array($response['makes'][0]['models']));
        $this->assertEquals(count($response['makes'][0]['models']), 1);
    }

    public function testGetByName()
    {
        $this->setMockResponse(__DIR__ . '/mocks/make_holder.txt');
        $args = array('makeNiceName' => 'amgeneral');
        $response = $this->client->getMakeByName($args);
        $this->assertMakeData($response);
    }

    public function testGetMakesCount()
    {
        $this->setMockResponse(__DIR__ . '/mocks/make_count.txt');
        $response = $this->client->getMakesCount();
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['makesCount'], 25);
    }

    private function assertMakeData($make)
    {
        $this->assertEquals($make['id'], 200347864);
        $this->assertTrue(is_array($make['models']));
        $model = $make['models'][0];
        $this->assertTrue(is_array($model));
    }

    private function assertVinDecoded($response)
    {
        $this->assertArrayHasKey('make', $response);
        $this->assertArrayHasKey('model', $response);
        $this->assertArrayHasKey('transmission', $response);
        $this->assertArrayHasKey('drivenWheels', $response);
        $this->assertArrayHasKey('numOfDoors', $response);
        $this->assertArrayHasKey('options', $response);
        $this->assertArrayHasKey('colors', $response);
        $this->assertEquals($response['manufacturerCode'], '1EH67');
        $this->assertArrayHasKey('price', $response);
        $this->assertArrayHasKey('categories', $response);
        $this->assertEquals($response['vin'], '2G1FC3D33C9165616');
        $this->assertEquals($response['squishVin'], '2G1FC3D3C9');
        $this->assertArrayHasKey('years', $response);
        $this->assertEquals($response['matchingType'], 'SQUISHVIN');
        $this->assertArrayHasKey('MPG', $response);
    }
}
