<?php

namespace Meklis\SwCoreClient\Objects;

use Meklis\SwCoreClient\Exceptions\SwitcherCoreException;

class Response
{
    /**
     * @var SwitcherCoreException
     */
    protected $error;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var array
     */
    protected $response;

    public static function init(Request $request, $response = null, ?SwitcherCoreException $error = null) {
        $self = new self();
        $self->setRequest($request)->setResponse($response)->setError($error);
        return $self;
    }

    /**
     * @return SwitcherCoreException | null
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param SwitcherCoreException $error
     * @return Response
     */
    public function setError(SwitcherCoreException $error): Response
    {
        $this->error = $error;
        return $this;
    }

    /**
     * @return Request
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function setRequest(Request $request): Response
    {
        $this->request = $request;
        return $this;
    }

    /**
     * @return array
     */
    public function getResponse()
    {
        return $this->response;
    }

    /**
     * @param array $response
     * @return Response
     */
    public function setResponse(array $response): Response
    {
        $this->response = $response;
        return $this;
    }


    function getAsArray() {
        return [
            'request' => $this->request->getAsArray(),
            'response' => $this->response,
            'error' => $this->error->getAsArray(),
        ];
    }

}