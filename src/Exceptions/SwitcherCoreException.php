<?php

namespace Meklis\SwCoreClient\Exceptions;

use Throwable;

class SwitcherCoreException extends \Exception
{
    protected $type = 'GENERAL_API_ERROR';

    protected $trace;

    function __construct($message = "", $code = 0, Throwable $previous = null, $trace = [])
    {
        $this->trace = $trace;
        parent::__construct($message, $code, $previous);
    }

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
            'trace' => $this->trace ? $this->trace : $this->getTrace() ,
            'previous' => $this->getPrevious(),
        ];
    }
}