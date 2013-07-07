<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Vehicle\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class RatingsAndReviewsRepositoryTest extends GuzzleTestCase
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

    public function testGetForMakeModelYear()
    {
        $this->setMockResponse($this->client, 'ratings_and_reviews.txt');
        $args = array('make' => 'Honda', 'model' => 'Accord', 'year' => 2005);
        $response = $this->client->getCommand('ratingsAndReviews.getForMakeModelYear', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['reviews']));
        $this->assertEquals(count($response['reviews']), 2);
        $this->assertEquals($response['reviews'][0]['styleId'], 100001207);
        $this->assertTrue(is_array($response['reviews'][0]['ratings']));
    }
}