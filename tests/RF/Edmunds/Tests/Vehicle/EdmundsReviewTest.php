<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class EdmundsReviewTest extends TestCase
{
    public function setUp()
    {
        parent::setUp();
        $this->client = Client::factory(array(
            'api_key' => 'API KEY GOES HERE',
            'baseUrl' => 'http://api.edmunds.com'
        ));
    }

    public function tearDown()
    {
        $this->client = null;
        parent::tearDown();
    }

    public function testGetEdmundsRatingsByMakeAndModelAndYear()
    {
        $this->setMockResponse(__DIR__ . '/mocks/edmunds_review.txt');
        $args = array('makeNiceName' => 'honda', 'modelNiceName' => 'accord', 'year' => 2005);
        $response = $this->client->getEdmundsRatingsByMakeAndModelAndYear($args);
        $this->assertRatings($response);
    }

    public function testGetEdmundsRatingsByStyleId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/edmunds_review.txt');
        $args = array('styleId' => 'SOME_ID');
        $response = $this->client->getEdmundsRatingsByStyleId($args);
        $this->assertRatings($response);
    }

    private function assertRatings($response)
    {
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['make']));
        $this->assertTrue(is_array($response['model']));
        $this->assertTrue(is_array($response['style']));
        $this->assertTrue(is_array($response['year']));
        $this->assertEquals($response['grade'], 'A');
        $this->assertEquals($response['date'], '8/28/2012');
        $this->assertTrue(is_array($response['ratings']));
        $this->assertTrue(is_array($response['ratings'][0]));
        $this->assertEquals($response['ratings'][0]['title'], 'Performance');
        $this->assertTrue(is_array($response['ratings'][0]['subRatings']));
        $this->assertTrue(is_array($response['ratings'][0]['subRatings'][0]));
        $this->assertEquals($response['ratings'][0]['subRatings'][0]['title'], 'Acceleration');
    }
}
