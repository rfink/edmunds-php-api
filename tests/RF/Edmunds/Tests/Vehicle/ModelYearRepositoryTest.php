<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Vehicle\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class ModelYearRepositoryTest extends GuzzleTestCase
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

    public function testFindById()
    {
        $this->setMockResponse($this->client, 'model_year_holder.txt');
        $args = array('id' => '100533210');
        $response = $this->client->getCommand('modelYear.findById', $args)->execute()->toArray();
        $this->assertModelYear($response);
    }

    public function testFindDistinctYearWithNew()
    {
        $this->setMockResponse($this->client, 'model_years.txt');
        $response = $this->client->getCommand('modelYear.findDistinctYearWithNew')->execute();
        $this->assertTrue(is_array($response));
        $this->assertTrue(in_array(2014, $response));
    }

    public function testFindDistinctYearWithNewOrUsed()
    {
        $this->setMockResponse($this->client, 'model_years.txt');
        $response = $this->client->getCommand('modelYear.findDistinctYearWithNewOrUsed')->execute();
        $this->assertTrue(is_array($response));
        $this->assertTrue(in_array(2014, $response));
    }

    public function testFindDistinctYearWithUsed()
    {
        $this->setMockResponse($this->client, 'model_years.txt');
        $response = $this->client->getCommand('modelYear.findDistinctYearWithUsed')->execute();
        $this->assertTrue(is_array($response));
        $this->assertTrue(in_array(2014, $response));
    }

    public function testFindFutureModelYearsByModelId()
    {
        $this->setMockResponse($this->client, 'model_years.txt');
        $args = array('modelId' => 'Honda_Civic');
        $response = $this->client->getCommand('modelYear.findFutureModelYearsByModelId', $args)->execute();
        $this->assertTrue(is_array($response));
        $this->assertTrue(in_array(2014, $response));
    }

    public function testFindModelYearsByMakeAndYear()
    {
        $this->setMockResponse($this->client, 'model_year_holder.txt');
        $args = array('make' => 'honda', 'year' => 2013);
        $response = $this->client->getCommand('modelYear.findModelYearsByMakeAndYear', $args)->execute()->toArray();
        $this->assertModelYear($response);
    }

    public function testFindModelYearsByMakeModel()
    {
        $this->setMockResponse($this->client, 'model_year_holder.txt');
        $args = array('make' => 'honda', 'model' => 'accord');
        $response = $this->client->getCommand('modelYear.findModelYearsByMakeModel', $args)->execute()->toArray();
        $this->assertModelYear($response);   
    }

    public function testFindNewAndUsedModelYearsByMakeIdAndYear()
    {
        $this->setMockResponse($this->client, 'model_year_holder.txt');
        $args = array('makeid' => '200001444', 'year' => '2013');
        $response = $this->client->getCommand('modelYear.findNewAndUsedModelYearsByMakeIdAndYear', $args)->execute()->toArray();
        $this->assertModelYear($response);
    }

    public function testFindNewModelYearsByModelId()
    {
        $this->setMockResponse($this->client, 'model_year_holder.txt');
        $args = array('modelid' => 'Acura_MDX');
        $response = $this->client->getCommand('modelYear.findNewModelYearsByModelId', $args)->execute()->toArray();
        $this->assertModelYear($response);
    }

    public function testFindUsedModelYearsByModelId()
    {
        $this->setMockResponse($this->client, 'model_year_holder.txt');
        $args = array('modelid' => 'Acura_MDX');
        $response = $this->client->getCommand('modelYear.findUsedModelYearsByModelId', $args)->execute()->toArray();
        $this->assertModelYear($response);
    }

    public function testFindYearsByCategoryAndPublicationState()
    {
        $this->setMockResponse($this->client, 'model_year_holder.txt');
        $args = array('category' => 'sedan', 'state' => 'new');
        $response = $this->client->getCommand('modelYear.findYearsByCategoryAndPublicationState', $args)->execute()->toArray();
        $this->assertModelYear($response);
    }

    public function testForModelId()
    {
        $this->setMockResponse($this->client, 'model_year_holder.txt');
        $args = array('modelid' => 'Acura_MDX');
        $response = $this->client->getCommand('modelYear.forModelId', $args)->execute()->toArray();
        $this->assertModelYear($response);
    }

    public function testForYearMakeModel()
    {
        $this->setMockResponse($this->client, 'model_year_holder.txt');
        $args = array('make' => 'acura', 'model' => 'mdx', 'year' => 2011);
        $response = $this->client->getCommand('modelYear.forYearMakeModel', $args)->execute()->toArray();
        $this->assertModelYear($response);
    }

    private function assertModelYear($response)
    {
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['modelYearHolder']));
        $this->assertTrue(is_array($response['modelYearHolder'][0]));
        $this->assertEquals($response['modelYearHolder'][0]['id'], 100533210);
    }
}
