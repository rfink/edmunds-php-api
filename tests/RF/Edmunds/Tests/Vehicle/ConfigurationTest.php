<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

class ConfigurationTest extends TestCase
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

    public function testGetDefaultVehicleConfiguration()
    {
        $this->setMockResponse(__DIR__ . '/mocks/configuration.txt');
        $args = array('styleid' => '0000000', 'zip' => '00001');
        $response = $this->client->getDefaultVehicleConfiguration($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['id'], 200477465);
        $this->assertTrue(is_array($response['pricingAttributeGroup']));
        $this->assertEquals($response['pricingAttributeGroup']['id'], 3);
        $this->assertTrue(is_array($response['pricingAttributeGroup']['attributes']['MSRP']));
    }

    public function testGetVehicleConfigurationWithOptions()
    {
        $this->setMockResponse(__DIR__ . '/mocks/configuration_with_options.txt');
        $args = array('styleid' => '000000', 'selected' => '000000', 'zip' => '00001');
        $response = $this->client->getVehicleConfigurationWithOptions($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['zipCode'], '90019');
        $this->assertEquals($response['styleId'], '200477465');
        $this->assertTrue(is_array($response['name']));
        $this->assertTrue(is_array($response['tmv']));
    }
}
