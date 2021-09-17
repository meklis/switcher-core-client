<?php

namespace Meklis\SwCoreClient\Exceptions;

use Throwable;

class NoRequiredFields extends SwitcherCoreException
{
    protected $type = 'NO_REQUIRED_FIELDS';

    /**
     * @return mixed
     */
    public function getType()
    {
        return $this->type;
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