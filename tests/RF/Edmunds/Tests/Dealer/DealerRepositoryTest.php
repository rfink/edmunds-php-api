<?php

namespace RF\Edmunds\Tests\Dealer;

use RF\Edmunds\Dealer\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class DealerRepositoryTest extends GuzzleTestCase
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

    public function testGet()
    {
        $this->setMockResponse($this->client, 'dealer_holder.txt');
        $args = array('zipcode' => '28226');
        $response = $this->client->getCommand('dealer.get', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertEquals(count($response[ 'dealerHolder' ]), 2);
        $dealer = $response[ 'dealerHolder' ][ 0 ];
        $this->assertTrue(is_array($dealer));
        $this->assertEquals($dealer[ 'locationId' ], '10691');
        $this->assertTrue(is_array($dealer[ 'address' ]));
    }
}