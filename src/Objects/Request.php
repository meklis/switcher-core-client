<?php

namespace Meklis\SwCoreClient\Objects;

class Request
{
    /**
     * @var Device
     */
    protected $device;

    protected $module;
    protected $arguments;

    public static function init(Device $device, $module, $arguments = []) {
        $self = new self();
        $self->setDevice($device)->setModule($module)->setArguments($arguments);
        return $self;
    }

    /**
     * @return mixed
     */
    public function getDevice()
    {
        return $this->device;
    }

    /**
     * @param mixed $device
     * @return Request
     */
    public function setDevice($device)
    {
        $this->device = $device;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * @param mixed $module
     * @return Request
     */
    public function setModule($module)
    {
        $this->module = $module;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param mixed $arguments
     * @return Request
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    public function getAsArray() {
        return [
            'device' => $this->device ? $this->device->getAsArray() : null,
            'module' => $this->module,
            'arguments' => $this->arguments
        ];
    }

    public function getHash() {
        $arguments = $this->getArguments();
        ksort($arguments);
        return md5($this->device->getIp() . $this->getModule() . json_encode($arguments));
    }
}