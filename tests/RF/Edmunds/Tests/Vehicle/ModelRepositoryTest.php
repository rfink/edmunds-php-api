<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class ModelRepositoryTest extends TestCase
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

    public function testGetByMakeAndModel()
    {
        $this->setMockResponse(__DIR__ . '/mocks/model_holder.txt');
        $args = array('makeNiceName' => 'AM_General_Hummer', 'modelNiceName' => 'Hummer');
        $response = $this->client->getModelByMakeAndModel($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['id'], 'Honda_Accord');
        $this->assertEquals($response['name'], 'Accord');
        $this->assertEquals($response['niceName'], 'accord');
        $this->assertTrue(is_array($response['years']));
        $this->assertTrue(is_array($response['years'][0]));
        $this->assertEquals($response['years'][0]['id'], '200487197');
        $this->assertTrue(is_array($response['years'][0]['styles']));
    }

    public function testGetByMake()
    {
        $this->setMockResponse(__DIR__ . '/mocks/models.txt');
        $args = array('makeNiceName' => 'bmw');
        $response = $this->client->getModelsByMake($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['models']));
        $this->assertEquals($response['models'][0]['id'], 'BMW_1_Series');
        $this->assertEquals($response['models'][0]['name'], '1 Series');
        $this->assertEquals($response['models'][0]['niceName'], '1-series');
        $this->assertTrue(is_array($response['models'][0]['years']));
        $this->assertEquals($response['models'][0]['years'][0]['id'], '100524709');
        $this->assertEquals($response['models'][0]['years'][0]['styles'][0]['id'], '100994560');
    }

    public function testGetModelsCount()
    {
        $this->setMockResponse(__DIR__ . '/mocks/model_count.txt');
        $args = array('make' => 'honda');
        $response = $this->client->getModelsCount($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['modelsCount'], 2);
    }
}
