<?php

namespace RF\Edmunds\Tests\Inventory;

use RF\Edmunds\Inventory\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class InventoryRepositoryTest extends GuzzleTestCase
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

    public function testGetInventoryByVin()
    {
        $this->setMockResponse($this->client, 'inventory_holder.txt');
        $args = array('vin' => 'WAUAFAFL0AN012824');
        $response = $this->client->getCommand('inventory.getInventoryByVin', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response[ 'resultsList' ]));
        $inventory = $response[ 'resultsList' ][ 0 ];
        $this->assertArrayHasKey('vin', $inventory);
        $this->assertTrue(is_array($inventory[ 'photoUrlsST' ]));
    }
}
