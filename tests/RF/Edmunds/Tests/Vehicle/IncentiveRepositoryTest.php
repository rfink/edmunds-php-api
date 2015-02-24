<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class IncentiveRepositoryTest extends TestCase
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

    public function testGetIncentiveById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/incentive_holder.txt');
        $args = array('id' => '2843330');
        $response = $this->client->getIncentiveById($args);
        $this->assertIncentiveData($response);
    }

    public function testGetIncentivesByCategoryAndZipCode()
    {
        $this->setMockResponse(__DIR__ . '/mocks/incentive_holder.txt');
        $args = array('category' => 'new', 'zipcode' => '28226');
        $response = $this->client->getIncentivesByCategoryAndZipCode($args);
        $this->assertIncentiveData($response);
    }

    public function testGetIncentivesByMakeId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/incentive_holder.txt');
        $args = array('makeid' => '200347864');
        $response = $this->client->getIncentivesByMakeId($args);
        $this->assertIncentiveData($response);
    }

    public function testGetIncentivesByMakeIdAndZipCode()
    {
        $this->setMockResponse(__DIR__ . '/mocks/incentive_holder.txt');
        $args = array('makeid' => '200347864', 'zipcode' => '28226');
        $response = $this->client->getIncentivesByMakeIdAndZipCode($args);
        $this->assertIncentiveData($response);
    }

    public function testGetIncentivesByModelYearIdAndZipCode()
    {
        $this->setMockResponse(__DIR__ . '/mocks/incentive_holder.txt');
        $args = array('modelyearid' => '100533210', 'zipcode' => '28226');
        $response = $this->client->getIncentivesByModelYearIdAndZipCode($args);
        $this->assertIncentiveData($response);
    }

    public function testGetIncentivesByStyleId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/incentive_holder.txt');
        $args = array('styleid' => '101200938');
        $response = $this->client->getIncentivesByStyleId($args);
        $this->assertIncentiveData($response);
    }

    public function testGetIncentivesByStyleIdAndZipCode()
    {
        $this->setMockResponse(__DIR__ . '/mocks/incentive_holder.txt');
        $args = array('styleid' => '101200938', 'zipcode' => '28226');
        $response = $this->client->getIncentivesByStyleIdAndZipCode($args);
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
