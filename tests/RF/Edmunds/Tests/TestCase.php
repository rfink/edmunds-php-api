<?php

namespace RF\Edmunds\Tests;

use GuzzleHttp\Subscriber\Mock;

class TestCase extends \PHPUnit_Framework_TestCase
{
    /**
     * @var GuzzleHttp\Command\Guzzle\GuzzleClient $client
     */
    protected $client = null;

    /**
     * @var GuzzleHttp\Subscriber\Mock
     */
    private $mock = null;

    public function setUp()
    {
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
    }

    public function setMockResponse($fileName)
    {
        $this->mock = new Mock([$fileName]);
        $this->client->getHttpClient()->getEmitter()->attach($this->mock);
    }
}
