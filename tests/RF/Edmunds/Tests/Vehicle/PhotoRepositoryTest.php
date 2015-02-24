<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class PhotoRepositoryTest extends TestCase
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

    public function testGetPhotosByStyleId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/photo_holder.txt');
        $args = array('styleId' => '101200938');
        $response = $this->client->getPhotosByStyleId($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals(count($response), 2);
        $photo = $response[0];
        $this->assertNotNull($photo['id']);
        $this->assertTrue(is_array($photo['photoSrcs']));
    }
}
