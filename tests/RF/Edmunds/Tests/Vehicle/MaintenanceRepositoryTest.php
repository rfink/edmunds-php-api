<?php

namespace RF\Edmunds\Tests\Vehicle;

use RF\Edmunds\Tests\TestCase;
use RF\Edmunds\Vehicle\Client;

/**
 * @author Ryan Fink <ryanjfink@gmail.com>
 */
class MaintenanceRepositoryTest extends TestCase
{
    public function setUp()
    {
        $this->client = Client::factory(array(
            'api_key' => 'API KEY GOES HERE',
            'baseUrl' => 'http://api.edmunds.com'
        ));
        parent::setUp();
    }

    public function tearDown()
    {
        parent::tearDown();
        $this->client = null;
    }

    public function testGetMaintenanceActionById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/action_holder.txt');
        $args = array('id' => '1680065');
        $response = $this->client->getMaintenanceActionById($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['actionHolder']));
        $this->assertTrue(is_array($response['actionHolder'][0]));
        $this->assertEquals($response['actionHolder'][0]['id'], 1680065);
    }

    public function testGetMaintenanceActionByModelYearId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/action_holder.txt');
        $args = array('modelyearid' => '1680065');
        $response = $this->client->getMaintenanceActionByModelYearId($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['actionHolder']));
        $this->assertTrue(is_array($response['actionHolder'][0]));
        $this->assertEquals($response['actionHolder'][0]['id'], 1680065);
    }

    public function testGetModelYearIdsWithMaintenanceSchedule()
    {
        $this->setMockResponse(__DIR__ . '/mocks/model_year_ids.txt');
        $response = $this->client->getModelYearIdsWithMaintenanceSchedule();
        $this->assertTrue(is_array($response));
        $yearIds = $response['longListHolder'];
        $this->assertEquals(count($yearIds), 4);
    }

    public function testGetRecallById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/recall_holder.txt');
        $args = array('id' => 177958);
        $response = $this->client->getRecallById($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['recallHolder']));
        $this->assertTrue(is_array($response['recallHolder'][0]));
        $this->assertEquals($response['recallHolder'][0]['id'], 177958);
    }

    public function testGetRecallByModelYearId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/recall_holder.txt');
        $args = array('modelyearid' => '100523189');
        $response = $this->client->getRecallByModelYearId($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['recallHolder']));
        $this->assertTrue(is_array($response['recallHolder'][0]));
        $this->assertEquals($response['recallHolder'][0]['id'], 177958);
    }

    public function testGetServiceBulletinById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/service_bulletin_holder.txt');
        $args = array('id' => '210998');
        $response = $this->client->getServiceBulletinById($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['serviceBulletinHolder']));
        $this->assertTrue(is_array($response['serviceBulletinHolder'][0]));
        $this->assertEquals($response['serviceBulletinHolder'][0]['id'], 210998);
    }

    public function testGetServiceBulletinByModelYearId()
    {
        $this->setMockResponse(__DIR__ . '/mocks/service_bulletin_holder.txt');
        $args = array('modelyearid' => '100000241');
        $response = $this->client->getServiceBulletinByModelYearId($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['serviceBulletinHolder']));
        $this->assertTrue(is_array($response['serviceBulletinHolder'][0]));
        $this->assertEquals($response['serviceBulletinHolder'][0]['id'], 210998);
    }

    public function testGetStyleNotesById()
    {
        $this->setMockResponse(__DIR__ . '/mocks/style_notes_holder.txt');
        $args = array('id' => '101287989');
        $response = $this->client->getStyleNotesById($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['maintenanceStyleNotesHolder']));
        $this->assertTrue(is_array($response['maintenanceStyleNotesHolder'][0]));
        $this->assertEquals($response['maintenanceStyleNotesHolder'][0]['style'], '/api/vehicle/style/101287989');       
    }

    public function testGetLaborRateByZip()
    {
        $this->setMockResponse(__DIR__ . '/mocks/zip_labor_rate_holder.txt');
        $args = array('zip' => 00001);
        $response = $this->client->getLaborRateByZip($args);
        $this->assertTrue(is_array($response));
        $this->assertTrue(is_array($response['zipLaborRateHolder']));
        $this->assertTrue(is_array($response['zipLaborRateHolder'][0]));
        $this->assertEquals($response['zipLaborRateHolder'][0]['laborRate'], 55);
    }
}
