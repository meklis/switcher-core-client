<?php

namespace Meklis\SwCoreClient\Objects;

class DeviceConnectionMetaData
{
    protected $telnet_port;
    protected $telnet_timeout_sec;
    protected $mikrotik_api_port;
    protected $snmp_timeout_sec;
    protected $snmp_repeats;

    /**
     * @return mixed
     */
    public function getTelnetPort()
    {
        return $this->telnet_port;
    }

    /**
     * @param mixed $telnet_port
     * @return DeviceConnectionMetaData
     */
    public function setTelnetPort($telnet_port)
    {
        $this->telnet_port = $telnet_port;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTelnetTimeoutSec()
    {
        return $this->telnet_timeout_sec;
    }

    /**
     * @param mixed $telnet_timeout_sec
     * @return DeviceConnectionMetaData
     */
    public function setTelnetTimeoutSec($telnet_timeout_sec)
    {
        $this->telnet_timeout_sec = $telnet_timeout_sec;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMikrotikApiPort()
    {
        return $this->mikrotik_api_port;
    }

    /**
     * @param mixed $mikrotik_api_port
     * @return DeviceConnectionMetaData
     */
    public function setMikrotikApiPort($mikrotik_api_port)
    {
        $this->mikrotik_api_port = $mikrotik_api_port;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSnmpTimeoutSec()
    {
        return $this->snmp_timeout_sec;
    }

    /**
     * @param mixed $snmp_timeout_sec
     * @return DeviceConnectionMetaData
     */
    public function setSnmpTimeoutSec($snmp_timeout_sec)
    {
        $this->snmp_timeout_sec = $snmp_timeout_sec;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getSnmpRepeats()
    {
        return $this->snmp_repeats;
    }

    /**
     * @param mixed $snmp_repeats
     * @return DeviceConnectionMetaData
     */
    public function setSnmpRepeats($snmp_repeats)
    {
        $this->snmp_repeats = $snmp_repeats;
        return $this;
    }


    public function getAsArray() {
        return [
            'telnet_timeout_sec' => $this->telnet_timeout_sec,
            'telnet_port' => $this->telnet_port,
            'mikrotik_api_port' => $this->mikrotik_api_port,
            'snmp_repeats' => $this->snmp_repeats,
            'snmp_timeout_sec' => $this->snmp_timeout_sec,
        ];
    }
}