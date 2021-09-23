<?php

namespace Meklis\SwCoreClient\Objects;

class DeviceModelData
{
    protected $name;
    protected $key;
    protected $ports;
    protected $extra;
    protected $detect;
    protected $device_type;
    protected $modules;
    protected $module_classes;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return DeviceModelData
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getKey()
    {
        return $this->key;
    }

    /**
     * @param mixed $key
     * @return DeviceModelData
     */
    public function setKey($key)
    {
        $this->key = $key;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPorts()
    {
        return $this->ports;
    }

    /**
     * @param mixed $ports
     * @return DeviceModelData
     */
    public function setPorts($ports)
    {
        $this->ports = $ports;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getExtra()
    {
        return $this->extra;
    }

    /**
     * @param mixed $extra
     * @return DeviceModelData
     */
    public function setExtra($extra)
    {
        $this->extra = $extra;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDetect()
    {
        return $this->detect;
    }

    /**
     * @param mixed $detect
     * @return DeviceModelData
     */
    public function setDetect($detect)
    {
        $this->detect = $detect;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeviceType()
    {
        return $this->deviceType;
    }

    /**
     * @param mixed $deviceType
     * @return DeviceModelData
     */
    public function setDeviceType($deviceType)
    {
        $this->deviceType = $deviceType;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModules()
    {
        return $this->modules;
    }

    /**
     * @param mixed $modules
     * @return DeviceModelData
     */
    public function setModules($modules)
    {
        $this->modules = $modules;
        return $this;
    }

    public static function initFromArray($arr) {
        $self = new self();
        foreach ($self->getAsArray() as $key=>$value) {
            $self->{$key} = isset($arr[$key]) ? $arr[$key] : null;
        }
        return $self;
    }

    function getAsArray() {
        return [
            'name' => $this->name,
            'key' => $this->key,
            'ports' => $this->ports,
            'extra' => $this->extra,
            'detect' => $this->detect,
            'device_type' => $this->device_type,
            'modules' => $this->modules,
            'module_classes' => $this->module_classes,
        ];
    }
}