<?php

namespace RF\Edmunds\Tests\Editorial;

use RF\Edmunds\Editorial\Client;
use RF\Edmunds\Tests\TestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class EditorialRepositoryTest extends TestCase
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

    public function testContent()
    {
        $this->setMockResponse(__DIR__ . '/mocks/content_holder.txt');
        $args = ['category' => 'reviews'];
        $response = $this->client->getContent($args);
        $this->assertTrue(is_array($response));
        $content = $response[0];
        $this->assertTrue(is_array($content));
        $this->assertEquals($content['link'], 'http://www.edmunds.com/jeep/grand-cherokee/2014/index.html');
        $this->assertEquals($content['title'], '2014 Jeep Grand Cherokee Review');
        $this->assertEquals($content['published'], '2013-05-01');
    }

    public function testGetReview()
    {
        $this->setMockResponse(__DIR__ . '/mocks/review_holder.txt');
        $args = ['year' => '2013', 'make' => 'toyota', 'model' => 'camry'];
        $response = $this->client->getReviewByMakeModelYear($args);
        $this->assertTrue(isset($response['editorial']));
        $this->assertEquals($response['editorial']['con'], '<p>Numb steering and mushy handling in all models but SE; no manual transmission available.</p>');
        $this->assertTrue(isset($response['editorial']['body']));
        $this->assertTrue(isset($response['editorial']['interior']));
        $this->assertTrue(isset($response['editorial']['legacy-id']));
        $this->assertTrue(isset($response['editorial']['link']));
        $this->assertTrue(isset($response['editorial']['metaKeywords']));
        $this->assertTrue(isset($response['editorial']['metaDescription']));
        $this->assertTrue(isset($response['editorial']['driving']));
        $this->assertTrue(isset($response['editorial']['whatsNew']));
        $this->assertTrue(isset($response['editorial']['videoReview']));
        $this->assertTrue(isset($response['editorial']['powertrain']));
        $this->assertTrue(isset($response['editorial']['fvEdmundsSays']));
        $this->assertTrue(isset($response['editorial']['safety']));
        $this->assertTrue(isset($response['editorial']['pro']));
        $this->assertTrue(isset($response['editorial']['edmundsSays']));
        $this->assertTrue(isset($response['editorial']['introduction']));
        $this->assertTrue(isset($response['editorial']['review']));
    }
}
