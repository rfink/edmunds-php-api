<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Vehicle\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class TmvRepositoryTest extends GuzzleTestCase
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

    public function testCalculateNewTmv()
    {
        $this->setMockResponse($this->client, 'tmv.txt');
        $args = array('styleid' => '', 'zip' => 00001);
        $response = $this->client->getCommand('tmv.calculateNewTmv', $args)->execute()->toArray();
        $this->assertTmvData($response);
    }

    public function testCalculateUsedTmv()
    {
        $this->setMockResponse($this->client, 'tmv.txt');
        $args = array('styleid' => '', 'zip' => 00001, 'condition' => 'Average', 'mileage' => '50000');
        $response = $this->client->getCommand('tmv.calculateUsedTmv', $args)->execute()->toArray();
        $this->assertTmvData($response);
    }

    public function testCalculateTypicallyEquippedUsedTmv()
    {
        $this->setMockResponse($this->client, 'tmv.txt');
        $args = array('styleid' => '', 'zip' => 00001, 'condition' => 'Average', 'mileage' => '50000');
        $response = $this->client->getCommand('tmv.calculateUsedTmv', $args)->execute()->toArray();
        $this->assertTmvData($response);
    }

    public function testFindCertifiedPriceForStyle()
    {
        $this->setMockResponse($this->client, 'certified_price.txt');
        $args = array('styleid' => '', 'zip' => 00001);
        $response = $this->client->getCommand('tmv.findCertifiedPriceForStyle', $args)->execute();
        $this->assertEquals($response, 33963.32);
    }

    public function testFindCpoYearsByMake()
    {
        $this->setMockResponse($this->client, 'cpo_years.txt');
        $args = array('makeid' => '');
        $response = $this->client->getCommand('tmv.findCpoYearsByMake', $args)->execute();
        $this->assertTrue(is_array($response));
        $this->assertTrue(in_array(2007, $response));
    }

    private function assertTmvData($response)
    {
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['tmv']));
    }
}