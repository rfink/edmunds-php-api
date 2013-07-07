<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Vehicle\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class TrueCostToOwnRepositoryTest extends GuzzleTestCase
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

    public function testNewTrueCostToOwnByStyleIdAndZip()
    {
        $this->setMockResponse($this->client, 'true_cost_to_own.txt');
        $args = array('styleId' => '', 'zip' => '00001');
        $response = $this->client->getCommand('trueCostToOwn.newTrueCostToOwnByStyleIdAndZip', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['value'], 17508);
    }

    public function testUsedTrueCostToOwnByStyleIdAndZip()
    {
        $this->setMockResponse($this->client, 'true_cost_to_own.txt');
        $args = array('styleId' => '', 'zip' => '00001');
        $response = $this->client->getCommand('trueCostToOwn.usedTrueCostToOwnByStyleIdAndZip', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['value'], 17508);
    }

    public function testResaleValuesByStyleIdAndZip()
    {
        $this->setMockResponse($this->client, 'resale_values.txt');
        $args = array('styleId' => '', 'zip' => '00001');
        $response = $this->client->getCommand('trueCostToOwn.resaleValuesByStyleIdAndZip', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['values']));
        $this->assertEquals($response['total'], 94881);
    }

    public function testDepreciationUsedRatesByStyleIdAndZip()
    {
        $this->setMockResponse($this->client, 'depreciation_rates.txt');
        $args = array('styleId' => '', 'zip' => '00001');
        $response = $this->client->getCommand('trueCostToOwn.depreciation.usedRatesByStyleIdAndZip', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['values']));
        $this->assertEquals($response['total'], 94881);
    }

    public function testDepreciationNewRatesByStyleIdAndZip()
    {
        $this->setMockResponse($this->client, 'depreciation_rates.txt');
        $args = array('styleId' => '', 'zip' => '00001');
        $response = $this->client->getCommand('trueCostToOwn.depreciation.newRatesByStyleIdAndZip', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['values']));
        $this->assertEquals($response['total'], 94881);
    }

    public function testNewTotalCashPriceByStyleIdAndZip()
    {
        $this->setMockResponse($this->client, 'true_cost_to_own.txt');
        $args = array('styleId' => '', 'zip' => '00001');
        $response = $this->client->getCommand('trueCostToOwn.newTotalCashPriceByStyleIdAndZip', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['value'], 17508);
    }

    public function testUsedTotalCashPriceByStyleIdAndZip()
    {
        $this->setMockResponse($this->client, 'true_cost_to_own.txt');
        $args = array('styleId' => '', 'zip' => '00001');
        $response = $this->client->getCommand('trueCostToOwn.usedTotalCashPriceByStyleIdAndZip', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['value'], 17508);
    }

    public function testGetMakesWithTcoData()
    {
        $this->setMockResponse($this->client, 'makes.txt');
        $response = $this->client->getCommand('trueCostToOwn.getMakesWithTcoData')->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['makes']));
        $this->assertTrue(array_key_exists('Acura', $response['makes']));
        $this->assertTrue(array_key_exists('id', $response['makes']['Acura']));
        $this->assertEquals($response['makes']['Acura']['id'], 200002038);
    }

    public function testGetModelsWithTcoData()
    {
        $this->setMockResponse($this->client, 'models.txt');
        $args = array('makeid' => '');
        $response = $this->client->getCommand('trueCostToOwn.getModelsWithTcoData', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['models']));
        $this->assertTrue(array_key_exists('accord:Coupe', $response['models']));
        $this->assertTrue(array_key_exists('id', $response['models']['accord:Coupe']));        $this->assertEquals($response['models']['accord:Coupe']['id'], 'Honda_Accord');
    }

    public function testGetStylesWithTcoDataBySubModel()
    {
        $this->setMockResponse($this->client, 'styles.txt');
        $args = array('make' => 'Honda', 'year' => 2013, 'submodel' => 'Coupe', 'makeyear' => 2013, 'model' => 'Accord');
        $response = $this->client->getCommand('trueCostToOwn.getStylesWithTcoDataBySubModel', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['styles']));
        $this->assertTrue(is_array($response['styles']['EX 2dr Coupe (2.4L 4cyl 6M)']));
        $this->assertEquals($response['styles']['EX 2dr Coupe (2.4L 4cyl 6M)']['id'], 200434886);
    }
}
