<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class ModelYearRepositoryTest extends TestCase
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

    public function testGetByMakeAndModel()
    {
        $this->setMockResponse(__DIR__ . '/mocks/model_year_holder.txt');
        $args = array('makeNiceName' => 'honda', 'modelNiceName' => 'accord');
        $response = $this->client->getModelYearsByMakeAndModel($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['years']));
        $this->assertTrue(is_array($response['years'][0]));
        $this->assertEquals($response['years'][0]['id'], '100537293');
        $this->assertTrue(is_array($response['years'][0]['styles']));
        $this->assertTrue(is_array($response['years'][0]['styles'][0]));
        $this->assertEquals($response['years'][0]['styles'][0]['id'], '200434889');
        $this->assertTrue(is_array($response['years'][0]['styles'][0]['submodel']));
    }

    public function testGetByMakeAndModelAndYear()
    {
        $this->setMockResponse(__DIR__ . '/mocks/model_year.txt');
        $args = array('makeNiceName' => 'honda', 'modelNiceName' => 'accord', 'year' => 2013);
        $response = $this->client->getModelYearByMakeAndModelAndYear($args);
        $this->assertTrue(is_array($response));
        $this->assertEquals($response['id'], '200442557');
        $this->assertTrue(is_array($response['styles']));
        $this->assertTrue(is_array($response['styles'][0]));
        $this->assertEquals($response['styles'][0]['id'], '200460762');
        $this->assertTrue(is_array($response['styles'][0]['submodel']));
    }

    public function testGetModelYearsCount()
    {
        $this->setMockResponse(__DIR__ . '/mocks/model_year_count.txt');
        $args = array('makeNiceName' => 'honda', 'modelNiceName' => 'accord');
        $response = $this->client->getModelYearsCount($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['years']));
        $this->assertTrue(is_array($response['years'][0]));
        $this->assertEquals($response['years'][0]['id'], '200477462');
        $this->assertEquals($response['years'][0]['year'], 2014);
        $this->assertEquals($response['years'][0]['stylesCount'], 8);
    }
}
