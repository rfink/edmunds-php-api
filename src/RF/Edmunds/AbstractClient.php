<?php

namespace RF\Edmunds;

use Guzzle\Service\Client;
use Guzzle\Common\Collection;

/**
 * TODO
 *
 * @author Ryan Fink <ryanjfink@gmail.com>
 * @since  March 17, 2013
 */
abstract class AbstractClient extends Client
{
    /**
     * Default API version
     *
     * @var string
     */
    const DEFAULT_VERSION = 'v1';

    /**
     * Constructor
     *
     * @param string $baseUrl
     * @param string $apiKey
     * @param string $version
     */
    public function __construct($baseUrl, $apiKey, $version = self::DEFAULT_VERSION)
    {
        $params = array();
        $params[self::COMMAND_PARAMS] = array('api_key' => $apiKey, 'version' => $version, 'fmt' => 'json');
        parent::__construct($baseUrl, $params);
    }

    /**
     * Prepare our default config
     *
     * @param array $config
     * @return array
     */
    public static function prepareConfig($config)
    {
        $defaults = array('version' => self::DEFAULT_VERSION);
        $required = array('base_url', 'api_key');

        return Collection::fromConfig($config, $defaults, $required);
    }
}
