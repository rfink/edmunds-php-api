<?php

namespace RF\Edmunds\Tests\Dealer;

use RF\Edmunds\Dealer\Client;
use RF\Edmunds\Tests\TestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class DealerRepositoryTest extends TestCase
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

    public function testGetDealerDetails()
    {
        $this->setMockResponse(__DIR__ . '/mocks/dealer.txt');
        $args = ['dealerId' => '3742'];
        $dealer = $this->client->getDealerDetails($args);
        $this->assertTrue(is_array($dealer));
        $this->assertEquals($dealer['dealerId'], '3742');
        $this->assertTrue(is_array($dealer['address']));
    }

    public function testSearchDealers()
    {
        $this->setMockResponse(__DIR__ . '/mocks/dealer_holder.txt');
        $args = ['zipcode' => '90210'];
        $response = $this->client->searchDealers($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals(count($response['dealers']), 10);
        $dealer = $response['dealers'][0];
        $this->assertTrue(is_array($dealer));
        $this->assertEquals($dealer['dealerId'], '867459');
        $this->assertTrue(is_array($dealer['address']));
    }

    public function testGetDealerCount()
    {
        $this->setMockResponse(__DIR__ . '/mocks/dealer_count.txt');
        $args = ['zipcode' => '90210'];
        $response = $this->client->getDealerCount($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['dealersCount'], 20);
    }
}
