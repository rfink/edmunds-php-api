<?php

namespace RF\Edmunds;

use GuzzleHttp\Client;
use GuzzleHttp\Command\Guzzle\GuzzleClient;
use GuzzleHttp\Command\Guzzle\Description;

/**
 * TODO
 *
 * @author Ryan Fink <ryanjfink@gmail.com>
 * @since  March 17, 2013
 */
abstract class AbstractClient extends Client
{
    /**
     * Constructor
     *
     * @param string $baseUrl
     * @param string $apiKey
     */
    public function __construct($baseUrl, $apiKey)
    {
        $params = [
            'base_url' => $baseUrl,
            'api_key' => $apiKey,
            'fmt' => 'json'
        ];
        parent::__construct($params);
    }
}
