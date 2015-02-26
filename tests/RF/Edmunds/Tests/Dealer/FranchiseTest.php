<?php

namespace RF\Edmunds\Tests\Dealer;

use RF\Edmunds\Dealer\Client;
use RF\Edmunds\Tests\TestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class FranchiseTest extends TestCase
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

    public function testGetFranchiseById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/franchise.txt');
        $args = array('id' => '00000');
        $response = $this->client->getFranchiseById($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['dealerId'], '3742');
        $this->assertEquals($response['state'], 'NEW');
        $this->assertEquals($response['premier'], true);
        $this->assertEquals($response['active'], true);
        $this->assertTrue(is_array($response['operations']));
        $this->assertTrue(is_array($response['address']));
        $this->assertTrue(is_array($response['make']));
        $this->assertTrue(is_array($response['contactInfo']));
    }

    public function testGetFranchises()
    {
        $this->setMockResponse(__DIR__ . '/mocks/franchise_holder.txt');
        $args = array('zipcode' => '00000');
        $response = $this->client->getFranchises($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['franchises']));
        $this->assertTrue(is_array($response['franchises'][0]));
        $this->assertEquals($response['franchises'][0]['dealerId'], '893');
        $this->assertEquals($response['franchises'][0]['active'], true);
        $this->assertEquals($response['franchises'][0]['franchiseId'], '26729');
        $this->assertEquals($response['franchises'][0]['lpStatus'], 'INACTIVE');
        $this->assertTrue(is_array($response['franchises'][0]['operations']));
        $this->assertTrue(is_array($response['franchises'][0]['address']));
        $this->assertTrue(is_array($response['franchises'][0]['make']));
        $this->assertTrue(is_array($response['franchises'][0]['tier']));
        $this->assertTrue(is_array($response['franchises'][0]['contactInfo']));
    }

    public function testGetFranchisesCount()
    {
        $this->setMockResponse(__DIR__ . '/mocks/franchise_count.txt');
        $args = array('zipcode' => '00000');
        $response = $this->client->getFranchisesCount($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['franchisesCount'], 20);
    }
}
