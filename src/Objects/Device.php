<?php

namespace Meklis\SwCoreClient\Objects;

use Meklis\SwCoreClient\Exceptions\NoRequiredFields;

class Device
{
    protected $ip;
    protected $community;
    protected $login;
    protected $password;
    /**
     * @var DeviceConnectionMetaData
     */
    protected $meta;

    /**
     * @return mixed
     */
    public function getIp()
    {
        return $this->ip;
    }

    /**
     * @param mixed $ip
     * @return Device
     */
    public function setIp($ip)
    {
        $this->ip = $ip;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getCommunity()
    {
        return $this->community;
    }

    /**
     * @param mixed $community
     * @return Device
     */
    public function setCommunity($community)
    {
        $this->community = $community;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLogin()
    {
        return $this->login;
    }

    /**
     * @param mixed $login
     * @return Device
     */
    public function setLogin($login)
    {
        $this->login = $login;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * @param mixed $password
     * @return Device
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getMeta()
    {
        return $this->meta;
    }

    /**
     * @param DeviceConnectionMetaData $meta
     * @return Device
     */
    public function setMeta(DeviceConnectionMetaData  $meta)
    {
        $this->meta = $meta;
        return $this;
    }

    public function getAsArray() {
        return [
            'ip' => $this->ip,
            'community' => $this->community,
            'login' => $this->login,
            'password' => $this->password,
            'meta' => $this->meta ? $this->meta->getAsArray() : null,
        ];
    }

    /**
     * @param $arr
     * @return Device
     * @throws NoRequiredFields
     */
    public static function initFromArray($arr) {
        $self = new self();
        if(isset($arr['ip'])) {
            $self->ip = $arr['ip'];
        } else {
            throw new NoRequiredFields("IP is required for device");
        }

        if(isset($arr['community'])) {
            $self->community = $arr['community'];
        } else {
            throw new NoRequiredFields("Community is required for device");
        }

        if(isset($arr['login'])) {
            $self->login = $arr['login'];
        }
        if(isset($arr['password'])) {
            $self->password = $arr['password'];
        }

        if(isset($arr['meta']) && $arr['meta']) {
            $meta = new DeviceConnectionMetaData();
            if(isset($arr['meta']['telnetPort'])) {
                $meta->setTelnetPort($arr['meta']['telnetPort']);
            }
            if(isset($arr['meta']['telnetTimeout'])) {
                $meta->setTelnetTimeoutSec($arr['meta']['telnetTimeout']);
            }
            if(isset($arr['meta']['mikrotikApiPort'])) {
                $meta->setMikrotikApiPort($arr['meta']['mikrotikApiPort']);
            }
            if(isset($arr['meta']['snmpTimeoutSec'])) {
                $meta->setSnmpTimeoutSec($arr['meta']['snmpTimeoutSec']);
            }
            if(isset($arr['meta']['snmpRepeats'])) {
                $meta->setSnmpRepeats($arr['meta']['snmpRepeats']);
            }
            $self->setMeta($meta);
        }
        return $self;
    }
}