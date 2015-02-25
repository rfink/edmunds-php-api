<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class TrueCostToOwnRepositoryTest extends TestCase
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

    public function testNewTrueCostToOwnByStyleIdAndZip()
    {
        $this->setMockResponse(__DIR__ . '/mocks/true_cost_to_own.txt');
        $args = array('styleId' => '', 'zip' => '00001');
        $response = $this->client->getNewTrueCostToOwnByStyleIdAndZip($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['value'], 17508);
    }

    public function testUsedTrueCostToOwnByStyleIdAndZip()
    {
        $this->setMockResponse(__DIR__ . '/mocks/true_cost_to_own.txt');
        $args = array('styleId' => '', 'zip' => '00001');
        $response = $this->client->getUsedTrueCostToOwnByStyleIdAndZip($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['value'], 17508);
    }

    public function testNewTotalCashPriceByStyleIdAndZip()
    {
        $this->setMockResponse(__DIR__ . '/mocks/true_cost_to_own.txt');
        $args = array('styleId' => '', 'zip' => '00001');
        $response = $this->client->getNewTotalCashPriceByStyleIdAndZip($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['value'], 17508);
    }

    public function testUsedTotalCashPriceByStyleIdAndZip()
    {
        $this->setMockResponse(__DIR__ . '/mocks/true_cost_to_own.txt');
        $args = array('styleId' => '', 'zip' => '00001');
        $response = $this->client->getUsedTotalCashPriceByStyleIdAndZip($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['value'], 17508);
    }

    public function testGetMakesWithTcoData()
    {
        $this->setMockResponse(__DIR__ . '/mocks/tco_makes.txt');
        $response = $this->client->getMakesWithTcoData();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['makes']));
        $this->assertTrue(array_key_exists('Acura', $response['makes']));
        $this->assertTrue(array_key_exists('id', $response['makes']['Acura']));
        $this->assertEquals($response['makes']['Acura']['id'], 200002038);
    }

    public function testGetModelsWithTcoData()
    {
        $this->setMockResponse(__DIR__ . '/mocks/tco_models.txt');
        $args = array('makeid' => '');
        $response = $this->client->getModelsWithTcoData($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['models']));
        $this->assertTrue(array_key_exists('econolinecargo:Van', $response['models']));
        $this->assertTrue(array_key_exists('id', $response['models']['econolinecargo:Van']));
        $this->assertEquals($response['models']['econolinecargo:Van']['id'], 'Ford_Econoline_Cargo');
    }

    public function testGetStylesWithTcoDataBySubModel()
    {
        $this->setMockResponse(__DIR__ . '/mocks/tco_styles.txt');
        $args = array('make' => 'Honda', 'year' => 2013, 'submodel' => 'Coupe', 'makeyear' => 2013, 'model' => 'Accord');
        $response = $this->client->getStylesWithTcoDataBySubModel($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['styles']));
        $this->assertTrue(is_array($response['styles']['EX 2dr Coupe (2.4L 4cyl 6M)']));
        $this->assertEquals($response['styles']['EX 2dr Coupe (2.4L 4cyl 6M)']['id'], 200434886);
    }

    public function testGetTcoForNewCar()
    {
        $this->markTestSkipped();
    }

    public function testGetTcoForUsedCar()
    {
        $this->markTestSkipped();
    }
}
