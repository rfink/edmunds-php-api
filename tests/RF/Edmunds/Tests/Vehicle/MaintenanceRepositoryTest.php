<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Vehicle\Client;
use Guzzle\Tests\GuzzleTestCase;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class MaintenanceRepositoryTest extends GuzzleTestCase
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

    public function testFindActionById()
    {
        $this->setMockResponse($this->client, 'action_holder.txt');
        $args = array('id' => '1680065');
        $response = $this->client->getCommand('maintenance.findActionById', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['actionHolder']));
        $this->assertTrue(is_array($response['actionHolder'][0]));
        $this->assertEquals($response['actionHolder'][0]['id'], 1680065);
    }

    public function testFindActionByModelYearId()
    {
        $this->setMockResponse($this->client, 'action_holder.txt');
        $args = array('modelyearid' => '1680065');
        $response = $this->client->getCommand('maintenance.findActionByModelYearId', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['actionHolder']));
        $this->assertTrue(is_array($response['actionHolder'][0]));
        $this->assertEquals($response['actionHolder'][0]['id'], 1680065);
    }

    public function testFindModelYearIdsWithMaintenanceSchedule()
    {
        $this->setMockResponse($this->client, 'model_year_ids.txt');
        $response = $this->client->getCommand('maintenance.findModelYearIdsWithMaintenanceSchedule')->execute()->toArray();
        $this->assertTrue(is_array($response));
        $yearIds = $response[ 'longListHolder' ];
        $this->assertEquals(count($yearIds), 4);
    }

    public function testFindRecallById()
    {
        $this->setMockResponse($this->client, 'recall_holder.txt');
        $args = array('id' => 177958);
        $response = $this->client->getCommand('maintenance.findRecallById', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['recallHolder']));
        $this->assertTrue(is_array($response['recallHolder'][0]));
        $this->assertEquals($response['recallHolder'][0]['id'], 177958);
    }

    public function testFindRecallByModelYearId()
    {
        $this->setMockResponse($this->client, 'recall_holder.txt');
        $args = array('modelyearid' => '100523189');
        $response = $this->client->getCommand('maintenance.findRecallByModelYearId', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['recallHolder']));
        $this->assertTrue(is_array($response['recallHolder'][0]));
        $this->assertEquals($response['recallHolder'][0]['id'], 177958);
    }

    public function testFindServiceBulletinById()
    {
        $this->setMockResponse($this->client, 'service_bulletin_holder.txt');
        $args = array('id' => '210998');
        $response = $this->client->getCommand('maintenance.findServiceBulletinById', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['serviceBulletinHolder']));
        $this->assertTrue(is_array($response['serviceBulletinHolder'][0]));
        $this->assertEquals($response['serviceBulletinHolder'][0]['id'], 210998);
    }

    public function testFindServiceBulletinByModelYearId()
    {
        $this->setMockResponse($this->client, 'service_bulletin_holder.txt');
        $args = array('modelyearid' => '100000241');
        $response = $this->client->getCommand('maintenance.findServiceBulletinByModelYearId', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['serviceBulletinHolder']));
        $this->assertTrue(is_array($response['serviceBulletinHolder'][0]));
        $this->assertEquals($response['serviceBulletinHolder'][0]['id'], 210998);
    }

    public function testFindStyleNotesById()
    {
        $this->setMockResponse($this->client, 'style_notes_holder.txt');
        $args = array('id' => '101287989');
        $response = $this->client->getCommand('maintenance.findStyleNotesById', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['maintenanceStyleNotesHolder']));
        $this->assertTrue(is_array($response['maintenanceStyleNotesHolder'][0]));
        $this->assertEquals($response['maintenanceStyleNotesHolder'][0]['style'], '/api/vehicle/style/101287989');       
    }

    public function testFindLaborRateByZip()
    {
        $this->setMockResponse($this->client, 'zip_labor_rate_holder.txt');
        $args = array('zip' => 00001);
        $response = $this->client->getCommand('maintenance.findLaborRateByZip', $args)->execute()->toArray();
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['zipLaborRateHolder']));
        $this->assertTrue(is_array($response['zipLaborRateHolder'][0]));
        $this->assertEquals($response['zipLaborRateHolder'][0]['laborRate'], 55);
    }
}
