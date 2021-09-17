<?php

namespace Meklis\SwCoreClient\Exceptions;

use Throwable;

class SwitcherCoreException extends \Exception
{
    protected $type = 'GENERAL_API_ERROR';

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
        return $this;
    }

    public function getAsArray() {
        return [
            'type' => $this->type,
            'message' => $this->message,
            'line' => $this->line,
            'file' => $this->file,
            'trace' => $this->getTrace(),
            'previous' => $this->getPrevious(),
        ];
    }
}