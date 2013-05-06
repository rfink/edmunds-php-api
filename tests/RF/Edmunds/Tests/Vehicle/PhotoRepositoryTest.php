<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Vehicle\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class PhotoRepositoryTest extends GuzzleTestCase
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

    public function testFindPhotosByStyleId()
    {
        $this->setMockResponse($this->client, 'photo_holder.txt');
        $args = array('styleId' => '101200938');
        $response = $this->client->getCommand('photo.findPhotosByStyleId', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertEquals(count($response), 2);
        $photo = $response[ 0 ];
        $this->assertNotNull($photo[ 'id' ]);
        $this->assertTrue(is_array($photo[ 'photoSrcs' ]));
    }
}