<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Vehicle\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class ModelRepositoryTest extends GuzzleTestCase
{
    public function setUp()
    {
        self::setMockBasePath(__DIR__ . DIRECTORY_SEPARATOR . 'mocks');
        $this->client = Client::factory(array(
            'api_key' => 'API KEY GOES HERE',
            'base_url' => 'http://api.edmunds.com'
        ));
    }

    public function tearDown()
    {
        self::setMockBasePath(null);
        $this->client = null;
    }

    public function testFindById()
    {
        $this->setMockResponse($this->client, 'model_holder.txt');
        $args = array('id' => 'AM_General_Hummer');
        $response = $this->client->getCommand('model.findById', $args)->execute()->toArray();
        $this->assertModelData($response);
    }

    public function testFindByMakeId()
    {
        $this->setMockResponse($this->client, 'model_holder.txt');
        $args = array('makeid' => 'AM_General_Hummer');
        $response = $this->client->getCommand('model.findByMakeId', $args)->execute()->toArray();
        $this->assertModelData($response);
    }

    public function testFindFutureModelsByMakeId()
    {
        $this->setMockResponse($this->client, 'model_holder.txt');
        $args = array('makeId' => 'AM_General_Hummer');
        $response = $this->client->getCommand('model.findFutureModelsByMakeId', $args)->execute()->toArray();
        $this->assertModelData($response);
    }

    public function testFindModelByMakeModelName()
    {
        $this->setMockResponse($this->client, 'model_holder.txt');
        $args = array('model' => 'hummer', 'make' => 'amgeneral');
        $response = $this->client->getCommand('model.findModelByMakeModelName', $args)->execute()->toArray();
        $this->assertModelData($response);
    }

    public function testFindModelsByMake()
    {
        $this->setMockResponse($this->client, 'model_holder.txt');
        $args = array('make' => 'amgeneral');
        $response = $this->client->getCommand('model.findModelsByMake', $args)->execute()->toArray();
        $this->assertModelData($response);
    }

    public function testFindModelsByMakeAndPublicationState()
    {
        $this->setMockResponse($this->client, 'model_holder.txt');
        $args = array('make' => 'amgeneral', 'state' => 'new');
        $response = $this->client->getCommand('model.findModelsByMakeAndPublicationState', $args)->execute()->toArray();
        $this->assertModelData($response);
    }

    public function testFindModelsByMakeAndYear()
    {
        $this->setMockResponse($this->client, 'model_holder.txt');
        $args = array('make' => 'amgeneral', 'year' => 2013);
        $response = $this->client->getCommand('model.findModelsByMakeAndYear', $args)->execute()->toArray();
        $this->assertModelData($response);
    }

    public function testFindNewAndUsedModelsByMakeId()
    {
        $this->setMockResponse($this->client, 'model_holder.txt');
        $args = array('makeId' => '200347864');
        $response = $this->client->getCommand('model.findNewAndUsedModelsByMakeId', $args)->execute()->toArray();
        $this->assertModelData($response);
    }

    public function testFindNewModelsByMakeId()
    {
        $this->setMockResponse($this->client, 'model_holder.txt');
        $args = array('makeId' => '200347864');
        $response = $this->client->getCommand('model.findNewModelsByMakeId', $args)->execute()->toArray();
        $this->assertModelData($response);
    }

    public function testFindUsedModelsByMakeId()
    {
        $this->setMockResponse($this->client, 'model_holder.txt');
        $args = array('makeId' => '200347864');
        $response = $this->client->getCommand('model.findUsedModelsByMakeId', $args)->execute()->toArray();
        $this->assertModelData($response);
    }

    private function assertModelData($response)
    {
        $this->assertTrue(is_array($response[ 'modelHolder' ]));
        $model = $response[ 'modelHolder' ][ 0 ];
        $this->assertEquals($model[ 'makeId' ], 200347864);
        $this->assertEquals($model[ 'id' ], 'AM_General_Hummer');
    }
}
