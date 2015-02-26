<?php

namespace RF\Edmunds\Tests\Dealer;

use RF\Edmunds\Dealer\Client;
use RF\Edmunds\Tests\TestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class RatingsAndReviewsTest extends TestCase
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

    public function testGetContentByDealerId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/ratings_and_reviews.txt');
        $args = array('dealerid' => '22222');
        $response = $this->client->getContentByDealerId($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['dealerId'], '26711');
        $this->assertEquals($response['locationId'], '879');
        $this->assertTrue(is_array($response['dealerAddress']));
        $this->assertTrue(is_array($response['dealerContactInfo']));
        $this->assertTrue(is_array($response['salesReviews']));
        $this->assertTrue(is_array($response['salesReviews'][0]));
        $this->assertEquals($response['salesReviews'][0]['id'], '568719954396962816');
    }

    public function testGetContentByZipAndMake()
    {
        $this->setMockResponse(__DIR__ . '/mocks/dealer_ratings_holder.txt');
        $args = array('zipcode' => '90210', 'make' => 'bmw');
        $response = $this->client->getContentByZipAndMake($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['salesReviews']));
        $this->assertTrue(is_array($response['salesReviews'][0]));
        $this->assertEquals($response['salesReviews'][0]['dealerId'], '1015');
        $this->assertEquals($response['salesReviews'][0]['locationId'], '1015');
        $this->assertEquals($response['salesReviews'][0]['id'], '563560460130353152');
        $this->assertEquals($response['salesReviews'][0]['averageRating'], 4.909);
        $this->assertEquals($response['salesReviews'][0]['totalRating'], 5.0);
    }
}
