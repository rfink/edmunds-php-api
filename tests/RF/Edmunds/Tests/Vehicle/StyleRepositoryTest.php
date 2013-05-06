<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Vehicle\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class StyleRepositoryTest extends GuzzleTestCase
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
        $this->setMockResponse($this->client, 'style_holder.txt');
        $args = array('id' => '101200938');
        $response = $this->client->getCommand('style.findById', $args)->execute()->toArray();
        $this->assertStyleData($response);
    }

    public function testFindStylesByMakeModelYear()
    {
        $this->setMockResponse($this->client, 'style_holder.txt');
        $args = array('make' => 'bmw', 'model' => '3series', 'year' => 2013);
        $response = $this->client->getCommand('style.findStylesByMakeModelYear', $args)->execute()->toArray();
        $this->assertStyleData($response);
    }

    public function testFindStylesByModelYearId()
    {
        $this->setMockResponse($this->client, 'style_holder.txt');
        $args = array('modelyearid' => '100529029');
        $response = $this->client->getCommand('style.findStylesByModelYearId', $args)->execute()->toArray();
        $this->assertStyleData($response);
    }

    private function assertStyleData($response)
    {
        $this->assertTrue(is_array($response[ 'styleHolder' ]));
        $style = $response[ 'styleHolder' ][ 0 ];
        $this->assertTrue(is_array($style[ 'specification' ]));
        $this->assertTrue(is_array($style[ 'standardEquipment' ]));
        $this->assertTrue(is_array($style[ 'optionalEquipment' ]));
        $this->assertTrue(is_array($style[ 'subModels' ]));
    }
}
