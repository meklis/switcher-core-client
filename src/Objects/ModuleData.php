<?php

namespace Meklis\SwCoreClient\Objects;

class ModuleData
{
    protected $name;
    protected $arguments;
    protected $description;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return ModuleData
     */
    public function setName($name)
    {
        $this->name = $name;
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
     * @return ModuleData
     */
    public function setArguments($arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     * @return ModuleData
     */
    public function setDescription($description)
    {
        $this->description = $description;
        return $this;
    }

    public static function init($name, $arguments = [], $description = '') {
        return (new self())
            ->setName($name)
            ->setArguments($arguments)
            ->setDescription($description);
    }

    public function getAsArray() {
        return [
          'name' => $this->name,
          'arguments' => $this->arguments,
          'description' => $this->description,
        ];
    }
}