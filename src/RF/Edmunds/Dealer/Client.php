<?php

namespace RF\Edmunds\Dealer;

use GuzzleHttp\Client as GuzzleHttpClient;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;

/**
 * TODO
 *
 * @author Ryan Fink <ryanjfink@gmail.com>
 * @since  March 18, 2013
 */
class Client
{
    /**
     * {@inheritDoc}
     */
    public static function factory($config = array())
    {
        $client = new GuzzleHttpClient();
        $serviceDesc = json_decode(file_get_contents(__DIR__ . DIRECTORY_SEPARATOR . 'service.json'), true);
        $description = new Description(array_merge($config, $serviceDesc));
        $opts = ['defaults' => array_merge($config, ['fmt' => 'json'])];

        return new GuzzleClient($client, $description, $opts);
    }
}
