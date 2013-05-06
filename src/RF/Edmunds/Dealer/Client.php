<?php

namespace RF\Edmunds\Dealer;

use RF\Edmunds\AbstractClient;
use Guzzle\Service\Description\ServiceDescription;

/**
 * TODO
 *
 * @author Ryan Fink <ryanjfink@gmail.com>
 * @since  March 18, 2013
 */
class Client extends AbstractClient
{
    /**
     * {@inheritDoc}
     */
    public static function factory($config = array())
    {
        $config = self::prepareConfig($config);
        $client = new static(
            $config->get('base_url'),
            $config->get('api_key'),
            $config->get('version')
        );
        $description = ServiceDescription::factory(__DIR__ . DIRECTORY_SEPARATOR . 'service.json');
        $client->setDescription($description);

        return $client;
    }
}
