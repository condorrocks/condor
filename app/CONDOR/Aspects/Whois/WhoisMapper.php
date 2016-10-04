<?php

namespace App\Condor\Aspects\Whois;

use Carbon\Carbon;

class WhoisMapper
{
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function map()
    {
        return [
            'domain'       => $this->readDomainName(),
            'expiry'       => $this->readExpiry(),
            'status'       => $this->readStatus(),
            'owner'        => $this->readOwnerName(),
            'ownerAddress' => $this->readOwnerAddress(),
            'nss'          => $this->readNameServers(),
            'registered'   => $this->readRegistered(),
        ];
    }

    protected function readNameServers()
    {
        return array_get($this->data, 'regrinfo.domain.nserver', []);
    }

    protected function readDomainName()
    {
        return array_get($this->data, 'regrinfo.domain.name');
    }

    protected function readRegistered()
    {
        return str_is('yes*', array_get($this->data, 'regrinfo.registered'));
    }

    protected function readExpiry()
    {
        $data = array_get($this->data, 'rawdata');

        foreach ($data as $record) {
            if ($this->isFound($date = $this->getValue('expiry', $record))) {
                return Carbon::parse($date)->toDateString();
            }
        }
    }

    protected function readStatus()
    {
        $data = array_get($this->data, 'rawdata');

        foreach ($data as $record) {
            if ($this->isFound($status = $this->getValue('status', $record))) {
                return $status;
            }
        }

        return 'Unknown';
    }

    protected function readOwnerName()
    {
        if ($this->isFound($name = array_get($this->data, 'regrinfo.owner.name', null))) {
            return $name;
        }

        $data = array_get($this->data, 'rawdata');

        foreach ($data as $record) {
            if ($this->isFound($owner = $this->getValue('owner name', $record))) {
                return $owner;
            }
        }

        return 'Unknown';
    }

    protected function readOwnerAddress()
    {
        if ($this->isFound($address = array_get($this->data, 'regrinfo.owner.address', null))) {
            return $address;
        }

        $data = array_get($this->data, 'rawdata');

        $address = [];
        foreach ($data as $record) {
            if ($this->isFound($addressLine = $this->getValue('owner addr', $record))) {
                $address[] = $addressLine;
            }
        }

        return implode(', ', $address);
    }

    /////////////
    // HELPERS //
    /////////////

    protected function isFound($value)
    {
        return $value !== null;
    }

    protected function getValue($field, $record)
    {
        if (stripos($record, $field) === false) {
            return;
        }

        list(, $value) = explode(': ', $record);

        return trim($value);
    }
}
