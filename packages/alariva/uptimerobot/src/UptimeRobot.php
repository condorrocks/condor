<?php

namespace Alariva\UptimeRobot;

/**
 * This project is an open source implementation for acessing the UptimeRobot api.
 * Full documentation: http://uptimerobot.com/api
 *
 * @version     1.0
 *
 * @author      Watchful
 * @authorUrl   http://www.watchful.li
 * @filesource  From mb2o <https://github.com/CodingOurWeb/PHP-wrapper-for-UptimeRobot-API>
 *
 * @license     GNU General Public License version 2 or later
 */
class UptimeRobot
{
    private $base_uri = 'https://api.uptimerobot.com';
    private static $apiKey;
    private static $noJsonCallback;
    private $format = 'json';

    /**
     * Set your API key
     *
     * @param string $key               require   Set your main API Key or Monitor-Specific API Keys (only getMonitors)
     * @param bool   $noJsonCallback    optional  Define if the function wrapper to be removed
     */
    public static function configure($key, $noJsonCallback = 1)
    {
        static::$apiKey = $key;
        static::$noJsonCallback = $noJsonCallback;
    }

    /**
     * Returns the API key
     */
    public function getApiKey()
    {
        if (empty(static::$apiKey)) {
            throw new \Exception('Value not specified: apiKey', 1);
        }

        return static::$apiKey;
    }

    /**
     * Gets output format of API calls
     */
    public function getFormat()
    {
        return $this->format;
    }

    /**
     * Sets output format of API calls xml / json
     *
     * @param mixed $format required
     */
    public function setFormat($format)
    {
        if (empty($format)) {
            throw new \Exception('Value not specified: format', 1);
        }

        if (($format != 'xml' && $format != 'json')) {
            throw new \Exception('Format not valid: format', 1);
        }

        $this->format = $format;
    }

    /**
     * Returns the result of the API calls
     *
     * @param mixed $url required
     */
    private function __fetch($url)
    {
        if (empty($url)) {
            throw new \Exception('Value not specified: url', 1);
        }

        if (preg_match("#\?#", $url)) {
            $url .= '&apiKey='.$this->getApiKey().'&rand='.mt_rand(1000000, 10000000);
        } else {
            $url .= '?apiKey='.$this->getApiKey().'&rand='.mt_rand(1000000, 10000000);
        }

        $url .= '&format='.$this->format;
        $url .= '&noJsonCallback='.static::$noJsonCallback;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $file_contents = curl_exec($ch);
        curl_close($ch);

        if ($this->format == 'xml') {
            return $file_contents;
        } else {
            if (static::$noJsonCallback) {
                return json_decode($file_contents);
            } else {
                return $file_contents;
            }
        }

        return false;
    }

    /**
     * This is a Swiss-Army knife type of a method for getting any information on monitors
     *
     * @param array|int $monitors               optional    if not used, will return all monitors in an account.
     *                                                      Else, it is possible to define any number of monitors with their IDs
     * @param array|int $customUptimeRatio      optional    Defines the number of days to calculate the uptime ratio(s)
     * @param bool  $logs                       optional    Defines if the logs of each monitor will be returned
     * @param bool  $responseTimes              optional    Defines if the response time data of each monitor will be returned
     * @param bool  $responseTimesAverage       optional    By default, response time value of each check is returned. The API can return average values in given minutes. Default is 0
     * @param bool  $alertContacts              optional    Defines if the notified alert contacts of each notification will be returned.
     *                                                      Requires logs to be set to 1
     * @param bool  $showMonitorAlertContacts   optional    Defines if the alert contacts set for the monitor to be returned
     * @param bool  $showTimezone               optional    Defines if the user's timezone should be returned
     * @param string $search                    optional    a keyword of your choice to search within monitorURL and monitorFriendlyName and get filtered results
     */
    public function getMonitors($monitors = null, $customUptimeRatio = null, $logs = 0, $responseTimes = 0, $responseTimesAverage = 0, $alertContacts = 0, $showMonitorAlertContacts = 0, $showTimezone = 0, $search = '')
    {
        $url = $this->base_uri.'/getMonitors';

        $url .= '?logs='.$logs.'&responseTimes='.$responseTimes.'&responseTimesAverage='.$responseTimesAverage.'&alertContacts='.$alertContacts.'&showMonitorAlertContacts='.$showMonitorAlertContacts.'&showTimezone='.$showTimezone;

        if (!empty($monitors)) {
            $url .= '&monitors='.$this->getImplode($monitors);
        }
        if (!empty($customUptimeRatio)) {
            $url .= '&customUptimeRatio='.$this->getImplode($customUptimeRatio);
        }

        if (!empty($search)) {
            $url .= '&search='.htmlspecialchars($search);
        }
        $result = $this->__fetch($url);
        $limit = $result->limit;
        $offset = $result->offset;
        $total = $result->total;

        while (($limit * $offset) + $limit < $total) {
            $result->limit = ($limit * $offset) + $limit;
            $offset++;
            $append = $this->__fetch($url.'&offset='.($offset * $limit));
            $result->monitors->monitor = array_merge($result->monitors->monitor, $append->monitors->monitor);
        }
        $result->limit = ($limit * $offset) + $limit;

        return $result;
    }

    /**
     * New monitors of any type can be created using this method
     *
     * @param string $friendlyName   required
     * @param string $URL            required
     * @param int    $type           required
     * @param int    $subType        optional (required for port monitoring)
     * @param int    $port           optional (required for port monitoring)
     * @param int    $keywordType    optional (required for keyword monitoring)
     * @param string $keywordValue   optional (required for keyword monitoring)
     * @param string $HTTPUsername   optional
     * @param string $HTTPPassword   optional
     * @param string $monitorInterval optional interval in min
     * @param array|int $alertContacts  optional The alert contacts to be notified Multiple alertContactIDs can be sent
     */
    public function newMonitor($friendlyName, $URL, $type, $subType = null, $port = null, $keywordType = null, $keywordValue = null, $HTTPUsername = null, $HTTPPassword = null, $alertContacts = null, $monitorInterval = 5)
    {
        if (empty($friendlyName) || empty($URL) || empty($type)) {
            throw new \Exception('Required key "name", "uri" or "type" not specified', 3);
        }

        $friendlyName = urlencode($friendlyName);
        $url = $this->base_uri.'/newMonitor?monitorFriendlyName='.$friendlyName.'&monitorURL='.$URL.'&monitorType='.$type;

        if (!empty($subType)) {
            $url .= '&monitorSubType='.$subType;
        }
        if (!empty($port)) {
            $url .= '&monitorPort='.$port;
        }
        if (isset($keywordType)) {
            $url .= '&monitorKeywordType='.$keywordType;
        }
        if (isset($keywordValue)) {
            $url .= '&monitorKeywordValue='.urlencode($keywordValue);
        }
        if (isset($HTTPUsername)) {
            $url .= '&monitorHTTPUsername='.urlencode($HTTPUsername);
        }
        if (isset($HTTPPassword)) {
            $url .= '&monitorHTTPPassword='.urlencode($HTTPPassword);
        }
        if (!empty($alertContacts)) {
            $url .= '&monitorAlertContacts='.$this->getImplode($alertContacts);
        }
        if (!empty($monitorInterval)) {
            $url .= '&monitorInterval='.$monitorInterval;
        }

        return $this->__fetch($url);
    }

    /**
     * Monitors can be edited using this method.
     *
     * Important: The type of a monitor can not be edited (like changing a HTTP monitor into a Port monitor).
     * For such cases, deleting the monitor and re-creating a new one is adviced.
     *
     * @param int    $monitorId      required
     * @param bool   $monitorStatus  optional
     * @param string $friendlyName   optional
     * @param string $URL            optional
     * @param int    $subType        optional (used only for port monitoring)
     * @param int    $port           optional (used only for port monitoring)
     * @param int    $keywordType    optional (used only for keyword monitoring)
     * @param string $keywordValue   optional (used only for keyword monitoring)
     * @param string $HTTPUsername   optional (in order to remove any previously added username, simply send the value empty)
     * @param string $HTTPPassword   optional (in order to remove any previously added password, simply send the value empty)
     * @param array|int  $alertContacts  optional   The alert contacts to be notified Multiple alertContactIDs can be sent
     *                                              (in order to remove any previously added alert contacts, simply send the value empty like '')
     */
    public function editMonitor($monitorId, $monitorStatus = null, $friendlyName = null, $URL = null, $subType = null, $port = null, $keywordType = null, $keywordValue = null, $HTTPUsername = null, $HTTPPassword = null, $alertContacts = null)
    {
        $url = $this->base_uri.'/editMonitor?monitorID='.$monitorId;

        if (isset($monitorStatus)) {
            $url .= '&monitorStatus='.$monitorStatus;
        }
        if (isset($friendlyName)) {
            $url .= '&monitorFriendlyName='.urlencode($friendlyName);
        }
        if (isset($URL)) {
            $url .= '&monitorURL='.$URL;
        }
        if (isset($subType)) {
            $url .= '&monitorSubType='.$subType;
        }
        if (isset($port)) {
            $url .= '&monitorPort='.$port;
        }
        if (isset($keywordType)) {
            $url .= '&monitorKeywordType='.$keywordType;
        }
        if (isset($keywordValue)) {
            $url .= '&monitorKeywordValue='.urlencode($keywordValue);
        }
        if (isset($HTTPUsername)) {
            $url .= '&monitorHTTPUsername='.urlencode($HTTPUsername);
        }
        if (isset($HTTPPassword)) {
            $url .= '&monitorHTTPPassword='.urlencode($HTTPPassword);
        }
        if (!empty($alertContacts)) {
            $url .= '&monitorAlertContacts='.$this->getImplode($alertContacts);
        }

        return $this->__fetch($url);
    }

    /**
     * Monitors can be deleted using this method.
     *
     * @param int $monitorId required
     */
    public function deleteMonitor($monitorId)
    {
        if (empty($monitorId)) {
            throw new \Exception('Value not specified: monitorId', 1);
        }

        $url = $this->base_uri.'/deleteMonitor?monitorID='.$monitorId;

        return $this->__fetch($url);
    }

    /**
     * The list of alert contacts can be called with this method.
     *
     * @param array|int $alertcontacts  optional    if not used, will return all alert contacts in an account.
     *                                              Else, it is possible to define any number of alert contacts with their IDs
     */
    public function getAlertContacts($alertcontacts = null)
    {
        $url = $this->base_uri.'/getAlertContacts';

        if (!empty($alertcontacts)) {
            $url .= '?alertcontacts='.$this->getImplode($alertcontacts);
        }

        return $this->__fetch($url);
    }

    /**
     * New alert contacts of any type (mobile/SMS alert contacts are not supported yet) can be created using this method.
     *
     * @param int       $alertContactType   required
     * @param string    $alertContactValue  required
     */
    public function newAlertContact($alertContactType, $alertContactValue)
    {
        if (empty($alertContactType) || empty($alertContactValue)) {
            throw new \Exception('Required params "$alertContactValue" or "$alertContactValue" not specified', 3);
        }

        $alertContactValue = urlencode($alertContactValue);

        $url = $this->base_uri.'/newAlertContact?alertContactType='.$alertContactType.'&alertContactValue='.$alertContactValue;

        return $this->__fetch($url);
    }

    /**
     * Alert contacts can be deleted using this method.
     *
     * @param int   $alertContactID     required
     */
    public function deleteAlertContact($alertContactID)
    {
        if (empty($alertContactID)) {
            throw new \Exception('Required params "$alertContactID" not specified', 3);
        }

        $url = $this->base_uri.'/deleteAlertContact?alertContactID='.$alertContactID;

        return $this->__fetch($url);
    }

    /**
     * Array or int to string with separator (-)
     *
     * @param array|int $var
     *
     * @return type string
     */
    private function getImplode($var)
    {
        if (is_array($var)) {
            return implode('-', $var);
        }

        return $var;
    }
}
