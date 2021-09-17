<?php

namespace Meklis\SwCoreClient\Objects;

class Request
{
    /**
     * @var Device
     */
    protected $device;

    protected $method;
    protected $arguments;

    public static function init(Device $device, $method, $arguments = []) {
        $self = new self();
        $self->setDevice($device)->setMethod($method)->setArguments($arguments);
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
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     * @return Request
     */
    public function setMethod($method)
    {
        $this->method = $method;
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
            'method' => $this->method,
            'arguments' => $this->arguments
        ];

    }
}