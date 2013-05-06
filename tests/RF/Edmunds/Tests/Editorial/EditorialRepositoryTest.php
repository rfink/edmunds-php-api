<?php

namespace RF\Edmunds\Tests\Editorial;

use RF\Edmunds\Editorial\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class EditorialRepositoryTest extends GuzzleTestCase
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

    public function testContent()
    {
        $this->setMockResponse($this->client, 'content_holder.txt');
        $args = array('category' => 'reviews');
        $response = $this->client->getCommand('editorial.get', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $content = $response[ 0 ];
        $this->assertTrue(is_array($content));
        $this->assertEquals($content[ 'link' ], 'http://www.edmunds.com/jeep/grand-cherokee/2014/index.html');
        $this->assertEquals($content[ 'title' ], '2014 Jeep Grand Cherokee Review');
        $this->assertEquals($content[ 'published' ], '2013-05-01');
    }
}
