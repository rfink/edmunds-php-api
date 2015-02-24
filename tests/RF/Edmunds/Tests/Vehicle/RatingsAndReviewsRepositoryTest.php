<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class RatingsAndReviewsRepositoryTest extends TestCase
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

    public function testGetForMakeModelYear()
    {
        $this->setMockResponse(__DIR__ . '/mocks/ratings_and_reviews.txt');
        $args = array('makeNiceName' => 'honda', 'modelNiceName' => 'accord', 'year' => 2005);
        $response = $this->client->getConsumerRatingsAndReviewsByMakeAndModelAndYear($args);
        $this->assertRatings($response);
    }

    public function testGetByStyleId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/ratings_and_reviews.txt');
        $args = array('styleId' => 'SOME_ID');
        $response = $this->client->getConsumerRatingsAndReviewsByStyleId($args);
        $this->assertRatings($response);
    }

    private function assertRatings($response)
    {
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['links']));
        $this->assertEquals($response['averageRating'], '4.156');
        $this->assertTrue(is_array($response['reviews']));
        $this->assertTrue(is_array($response['reviews'][0]));
        $this->assertTrue(is_array($response['reviews'][0]['ratings']));
        $this->assertTrue(is_array($response['reviews'][0]['ratings'][0]));
    }
}
