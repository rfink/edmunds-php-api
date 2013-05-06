<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Vehicle\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class MakeRepositoryTest extends GuzzleTestCase
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
    
    public function testVinDecoder()
    {
        $this->setMockResponse($this->client, 'vin_decoder.txt');
        $args = array('vin' => 'JTEBU17R848028574');
        $response = $this->client->getCommand('tools.vinDecoder', $args)->execute()->toArray();
        $this->assertTrue(is_array($response[ 'styleHolder' ]));
        $this->assertEquals(count($response[ 'styleHolder' ]), 1);
        $style = $response[ 'styleHolder' ][0];
        $this->assertEquals($style[ 'id' ], 100336294);
        $this->assertTrue(is_array($style[ 'price' ]));
        $this->assertEquals($style[ 'price' ][ 'baseMSRP' ], 35820.0);
    }

    public function testFindAll()
    {
        $this->setMockResponse($this->client, 'make_holder.txt');
        $response = $this->client->getCommand('make.findAll')->execute()->toArray();
        $this->assertMakeData($response);
    }

    public function testFindById()
    {
        $this->setMockResponse($this->client, 'make_holder.txt');
        $args = array('id' => '200347864');
        $response = $this->client->getCommand('make.findById', $args)->execute()->toArray();
        $this->assertMakeData($response);
    }

    public function testFindFutureMakes()
    {
        $this->setMockResponse($this->client, 'make_holder.txt');
        $response = $this->client->getCommand('make.findFutureMakes')->execute()->toArray();
        $this->assertMakeData($response);
    }

    public function testFindMakeByName()
    {
        $this->setMockResponse($this->client, 'make_holder.txt');
        $args = array('name' => 'amgeneral');
        $response = $this->client->getCommand('make.findMakeByName', $args)->execute()->toArray();
        $this->assertMakeData($response);
    }

    public function testFindMakesByModelYear()
    {
        $this->setMockResponse($this->client, 'make_holder.txt');
        $args = array('year' => '2013');
        $response = $this->client->getCommand('make.findMakesByModelYear', $args)->execute()->toArray();
        $this->assertMakeData($response);
    }

    public function testFindMakesByPublicationState()
    {
        $this->setMockResponse($this->client, 'make_holder.txt');
        $args = array('state' => 'used');
        $response = $this->client->getCommand('make.findMakesByPublicationState', $args)->execute()->toArray();
        $this->assertMakeData($response);
    }

    public function testFindNewAndUsed()
    {
        $this->setMockResponse($this->client, 'make_holder.txt');
        $response = $this->client->getCommand('make.findNewAndUsed')->execute()->toArray();
        $this->assertMakeData($response);
    }

    public function testFindNewAndUsedMakesByModelYear()
    {
        $this->setMockResponse($this->client, 'make_holder.txt');
        $args = array('year' => '2013');
        $response = $this->client->getCommand('make.findNewAndUsedMakesByModelYear', $args)->execute()->toArray();
        $this->assertMakeData($response);
    }

    public function testFindNewMakes()
    {
        $this->setMockResponse($this->client, 'make_holder.txt');
        $response = $this->client->getCommand('make.findNewMakes')->execute()->toArray();
        $this->assertMakeData($response);
    }

    public function testFindUsedMakes()
    {
        $this->setMockResponse($this->client, 'make_holder.txt');
        $response = $this->client->getCommand('make.findUsedMakes')->execute()->toArray();
        $this->assertMakeData($response);
    }

    private function assertMakeData($response)
    {
        $this->assertTrue(is_array($response[ 'makeHolder' ]));
        $this->assertEquals(count($response[ 'makeHolder' ]), 2);
        $make = $response[ 'makeHolder' ][ 0 ];
        $this->assertEquals($make[ 'id' ], 200347864);
        $this->assertTrue(is_array($make[ 'models' ]));
        $model = $make[ 'models' ][ 0 ];
        $this->assertTrue(is_array($model));
        $this->assertEquals($model[ 'link' ], '/api/vehicle/am-general/hummer');
    }
}
