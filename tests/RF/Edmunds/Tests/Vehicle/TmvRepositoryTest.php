<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class TmvRepositoryTest extends TestCase
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

    public function testCalculateNewTmvByMakeAndYearAndZip()
    {
        $this->setMockResponse(__DIR__ . '/mocks/tmv_v2.txt');
        $args = array('makeNiceName' => 'bmw', 'year' => '2000', 'zip' => '00001', 'msrp' => 'somevalue');
        $response = $this->client->calculateNewTmvByMakeAndYearAndZip($args);
        $this->assertTmvV2Data($response);
    }

    public function testCalculateNewTmvByVinAndMsrpAndZip()
    {
        $this->setMockResponse(__DIR__ . '/mocks/tmv_v2_pricing.txt');
        $args = array('vin' => '11111111111111111', 'zip' => '00001', 'msrp' => 'somevalue');
        $response = $this->client->calculateNewTmvByVinAndMsrpAndZip($args);
        $this->assertTrue(is_array($response));
        $this->assertTmvV2Data($response['pricing']);
        $this->assertTrue(is_array($response['configuration']));
    }

    public function testCalculateNewTmvByStyleAndZip()
    {
        $this->setMockResponse(__DIR__ . '/mocks/tmv.txt');
        $args = array('styleid' => '', 'zip' => '00001');
        $response = $this->client->calculateNewTmvByStyleAndZip($args);
        $this->assertTmvData($response);
    }

    public function testCalculateUsedTmv()
    {
        $this->setMockResponse(__DIR__ . '/mocks/tmv.txt');
        $args = array('styleid' => '', 'zip' => '00001', 'condition' => 'Average', 'mileage' => '50000');
        $response = $this->client->calculateUsedTmv($args);
        $this->assertTmvData($response);
    }

    public function testCalculateTypicallyEquippedUsedTmv()
    {
        $this->setMockResponse(__DIR__ . '/mocks/tmv.txt');
        $args = array('styleid' => '', 'zip' => '00001', 'condition' => 'Average', 'mileage' => '50000');
        $response = $this->client->calculateTypicallyEquippedUsedTmv($args);
        $this->assertTmvData($response);
    }

    public function testGetCertifiedPriceForStyle()
    {
        $this->markTestIncomplete();
        $this->setMockResponse(__DIR__ . '/mocks/certified_price.txt');
        $args = array('styleid' => '', 'zip' => '00001');
        $response = $this->client->getCertifiedPriceForStyle($args);
        $this->assertEquals($response, 33963.32);
    }

    private function assertTmvData($response)
    {
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['tmv']));
    }

    private function assertTmvV2Data($response)
    {
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['link']));
        $this->assertTrue(is_array($response['corePercent']));
        $this->assertTrue(is_array($response['regionAdjustment']));
        $this->assertTrue(is_array($response['colorAdjustment']));
        $this->assertEquals($response['tmvUsd'], 27835);
    }
}
