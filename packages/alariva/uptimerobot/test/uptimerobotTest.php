<?php
/**
 * PHPUnit test file
 * 
 * @version     1.0
 * @author      Watchful
 * @authorUrl   http://www.watchful.li
 * @license     GNU General Public License version 2 or later
 */
require_once './../src/uptimerobot.php';
class UptimeRobotTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var UptimeRobot
     */
    protected $object;
    static $newMonitorId;
    static $newUserId;
    protected $apiKey = 'YOUR-API';
    protected $email = 'YOUR@EMAIL.com';

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->object = new UptimeRobot;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        
    }

    /**
     * Without configuration
     * 
     * @covers UptimeRobot::getApiKey
     * @expectedException Exception
     */
    public function testGetApiKey_whitoutConf()
    {
        $this->object->getApiKey();
    }

    /**
     * Generated from @assert
     *
     * @covers UptimeRobot::configure
     */
    public function testConfigure()
    {
        $this->assertEquals(0, UptimeRobot::configure($this->apiKey, 1));
    }

    /**
     * With configuration
     * 
     * @covers UptimeRobot::getApiKey
     */
    public function testGetApiKey()
    {
        $this->object->getApiKey();
    }

    /**
     * Generated from @assert ('xml') == 0.
     *
     * @covers UptimeRobot::setFormat
     */
    public function testSetFormat_1()
    {
        $this->assertEquals(0, $this->object->setFormat('xml'));
    }

    /**
     * Generated from @assert ('json') == 0.
     *
     * @covers UptimeRobot::setFormat
     */
    public function testSetFormat_2()
    {
        $this->assertEquals(0, $this->object->setFormat('json'));
    }

    /**
     * Generated from @assert ('test') throws Exception.
     *
     * @covers UptimeRobot::setFormat
     * @expectedException Exception
     */
    public function testSetFormat_err()
    {
        $this->object->setFormat('test');
    }

    /**
     * @covers UptimeRobot::getFormat
     */
    public function testGetFormat()
    {
        $this->object->getFormat();
    }

    /**
     * @covers UptimeRobot::getMonitors
     */
    public function testGetMonitors_1()
    {
        $this->assertNotEquals(null, $this->object->getMonitors());
    }

    /**
     * @covers UptimeRobot::newMonitor
     */
    public function testNewMonitor()
    {
        $newMonitor = $this->object->newMonitor("Google", 'https://google.com', 1);
        $this->assertNotEquals(null, $newMonitor);

        static::$newMonitorId = $newMonitor->monitor->id;
    }

    /**
     * @covers UptimeRobot::getMonitors
     */
    public function testGetMonitors_created()
    {
        $this->assertNotEquals(null, $this->object->getMonitors($monitors = static::$newMonitorId, $customUptimeRatio = null, $logs = 1, $responseTimes = 1, $responseTimesAverage = 1, $alertContacts = 1, $showMonitorAlertContacts = 1, $showTimezone = 1));
    }

    /**
     * @covers UptimeRobot::editMonitor
     */
    public function testEditMonitor()
    {
        $this->assertNotEquals(null, $this->object->editMonitor($monitorId = static::$newMonitorId, $monitorStatus = 0, $friendlyName = 'Edit 1', $URL = 'http://google.com', $subType = null, $port = null, $keywordType = null, $keywordValue = null, $HTTPUsername = null, $HTTPPassword = null));
    }

    /**
     * @covers UptimeRobot::deleteMonitor
     */
    public function testDeleteMonitor_1()
    {
        $this->assertNotEquals(null, $this->object->deleteMonitor(static::$newMonitorId));
    }

    /**
     * @covers UptimeRobot::deleteMonitor
     * @expectedException Exception
     */
    public function testDeleteMonitor_whitout_params()
    {
        $this->object->deleteMonitor();
    }

    /**
     * @covers UptimeRobot::getAlertContacts
     */
    public function testGetAlertContacts_all()
    {
        $this->assertNotEquals(null, $this->object->getAlertContacts());
    }

    /**
     * @covers UptimeRobot::newAlertContact
     */
    public function testNewAlertContact()
    {
        $user = $this->object->newAlertContact('2', $this->email);
        $this->assertNotEquals(null, $user);

        static::$newUserId = $user->alertcontact->id;
    }

    /**
     * @covers UptimeRobot::getAlertContacts
     */
    public function testGetAlertContacts_created()
    {
        $this->assertNotEquals(null, $this->object->getAlertContacts(static::$newUserId));
    }

    /**
     * @covers UptimeRobot::deleteAlertContact
     */
    public function testDeleteAlertContact()
    {
        $this->assertNotEquals(null, $this->object->deleteAlertContact(static::$newUserId));
    }

}