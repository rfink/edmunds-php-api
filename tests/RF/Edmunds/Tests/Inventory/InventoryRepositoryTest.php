<?php

namespace RF\Edmunds\Tests\Inventory;

use RF\Edmunds\Inventory\Client;
use RF\Edmunds\Tests\TestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class InventoryRepositoryTest extends TestCase
{
    public function setUp()
    {
        $this->client = Client::factory(array(
            'api_key' => 'API KEY GOES HERE',
            'baseUrl' => 'https://api.edmunds.com'
        ));
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->client = null;
    }

    public function testGetInventoryByVin()
    {
        $this->setMockResponse(__DIR__ . '/mocks/inventory_holder.txt');
        $args = [
            'vin' => 'WAUAFAFL0AN012824',
            'zipcode' => 99999,
            'range' => 25
        ];
        $response = $this->client->getByVin($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['resultsList']));
        $inventory = $response['resultsList'][0];
        $this->assertArrayHasKey('vin', $inventory);
        $this->assertTrue(is_array($inventory['photoUrlsST']));
    }
}
