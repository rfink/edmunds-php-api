<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Vehicle\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class IncentiveRepositoryTest extends GuzzleTestCase
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
        $this->setMockResponse($this->client, 'incentive_holder.txt');
        $args = array('id' => '2843330');
        $response = $this->client->getCommand('incentive.findById', $args)->execute()->toArray();
        $this->assertIncentiveData($response);
    }

    public function testFindIncentivesByCategoryAndZipCode()
    {
        $this->setMockResponse($this->client, 'incentive_holder.txt');
        $args = array('category' => 'new', 'zipcode' => '28226');
        $response = $this->client->getCommand('incentive.findIncentivesByCategoryAndZipCode', $args)->execute()->toArray();
        $this->assertIncentiveData($response);
    }

    public function testFindIncentivesByMakeId()
    {
        $this->setMockResponse($this->client, 'incentive_holder.txt');
        $args = array('makeid' => '200347864');
        $response = $this->client->getCommand('incentive.findIncentivesByMakeId', $args)->execute()->toArray();
        $this->assertIncentiveData($response);
    }

    public function testFindIncentivesByMakeIdAndZipCode()
    {
        $this->setMockResponse($this->client, 'incentive_holder.txt');
        $args = array('makeid' => '200347864', 'zipcode' => '28226');
        $response = $this->client->getCommand('incentive.findIncentivesByMakeIdAndZipCode', $args)->execute()->toArray();
        $this->assertIncentiveData($response);
    }

    public function testFindIncentivesByModelYearIdAndZipCode()
    {
        $this->setMockResponse($this->client, 'incentive_holder.txt');
        $args = array('modelyearid' => '100533210', 'zipcode' => '28226');
        $response = $this->client->getCommand('incentive.findIncentivesByModelYearIdAndZipCode', $args)->execute()->toArray();
        $this->assertIncentiveData($response);
    }

    public function testFindIncentivesByStyleId()
    {
        $this->setMockResponse($this->client, 'incentive_holder.txt');
        $args = array('styleid' => '101200938');
        $response = $this->client->getCommand('incentive.findIncentivesByStyleId', $args)->execute()->toArray();
        $this->assertIncentiveData($response);
    }

    public function testFindIncentivesByStyleIdAndZipCode()
    {
        $this->setMockResponse($this->client, 'incentive_holder.txt');
        $args = array('styleid' => '101200938', 'zipcode' => '28226');
        $response = $this->client->getCommand('incentive.findIncentivesByStyleIdAndZipCode', $args)->execute()->toArray();
        $this->assertIncentiveData($response);
    }

    private function assertIncentiveData($response)
    {
        $this->assertTrue(is_array($response));
        $this->assertEquals(count($response[ 'incentiveHolder' ]), 2);
        $incentive = $response[ 'incentiveHolder' ][ 0 ];
        $this->assertArrayHasKey('id', $incentive);
    }
}
