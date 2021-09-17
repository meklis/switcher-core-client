<?php

namespace Meklis\SwCoreClient;

use Curl\Curl;
use Meklis\SwCoreClient\Exceptions\SwitcherCoreApiServerErrors;
use Meklis\SwCoreClient\Exceptions\SwitcherCoreException;
use Meklis\SwCoreClient\Objects\Device;
use Meklis\SwCoreClient\Objects\DeviceConnectionMetaData;
use Meklis\SwCoreClient\Objects\DeviceModelData;
use Meklis\SwCoreClient\Objects\Request;
use Meklis\SwCoreClient\Objects\Response;

class Client
{

    protected $swCoreAddr;
    protected $requestTimeoutSec = 30;
    protected $requestConcurrency = 10;

    function __construct($switcherCoreAddress = "http://127.0.0.1:5990")
    {
        $this->swCoreAddr = $switcherCoreAddress;
    }

    /**
     * @return mixed|string
     */
    public function getSwCoreAddr()
    {
        return $this->swCoreAddr;
    }

    /**
     * @param mixed|string $swCoreAddr
     * @return Client
     */
    public function setSwCoreAddr($swCoreAddr)
    {
        $this->swCoreAddr = $swCoreAddr;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestTimeoutSec()
    {
        return $this->requestTimeoutSec;
    }

    /**
     * @param mixed $requestTimeoutSec
     * @return Client
     */
    public function setRequestTimeoutSec($requestTimeoutSec)
    {
        $this->requestTimeoutSec = $requestTimeoutSec;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getRequestConcurrency()
    {
        return $this->requestConcurrency;
    }

    /**
     * @param mixed $requestConcurrency
     * @return Client
     */
    public function setRequestConcurrency($requestConcurrency)
    {
        $this->requestConcurrency = $requestConcurrency;
        return $this;
    }

    /**
     * @param Request $req
     * @return Response
     */
    function call(Request $req)
    {
        $curl = new Curl();
        $curl->setDefaultJsonDecoder($assoc = true);
        $curl->setHeader('Content-Type', 'application/json');
        $curl->setTimeout($this->requestTimeoutSec);
        $curl->post($this->swCoreAddr . '/call', $req->getAsArray());
        $response = $curl->response;
        $resp = (new Response())->setRequest($req);
        if (isset($response['data'])) {
            $resp->setResponse($response['data']);
        }
        if (isset($response['error'])) {
            throw new SwitcherCoreException($response['error']['description']);
        } elseif ($curl->error) {
            throw new SwitcherCoreApiServerErrors($curl->error->errorMessage, $curl->error->errorCode);
        };
        return $resp;
    }

    /**
     * @param Request[] $req
     * @return Response[]
     */
    function callBatch(array $req)
    {
        $curl = new Curl();
        $curl->setDefaultJsonDecoder($assoc = true);
        $curl->setTimeout($this->requestTimeoutSec);
        $curl->setHeader('Content-Type', 'application/json');
        $reqs = [];
        foreach ($req as $r) {
            $reqs[] = $r->getAsArray();
        }
        $curl->post($this->swCoreAddr . '/call-batch', $reqs);
        if (isset($curl->response['error'])) {
            throw new SwitcherCoreException($curl->response['error']['description']);
        } elseif ($curl->error) {
            throw new SwitcherCoreApiServerErrors($curl->error->errorMessage, $curl->error->errorCode);
        }

        $responses = [];
        if (isset($curl->response['data'])) {
            foreach ($curl->response['data'] as $response) {
                $resp = new Response();
                if (isset($response['error'])) {
                    $resp->setError(new SwitcherCoreException($response['error']['message']));
                }
                if (isset($response['request'])) {
                    $request = new Request();
                    if (isset($response['request']['device'])) {
                        $request->setDevice(Device::initFromArray($response['request']['device']));
                    }
                    if (isset($response['request']['method'])) {
                        $request->setMethod($response['data']['request']['method']);
                    }
                    if (isset($response['request']['arguments'])) {
                        $request->setArguments($response['request']['arguments']);
                    }
                    $resp->setRequest($request);
                }
                if (isset($response['data'])) {
                    $resp->setResponse($response['data']);
                }
                $responses[] = $resp;
            }
        }
        return $responses;
    }

    /**
     * @param Request[] $req
     * @return Response[]
     */
    function callMulti(array $req)
    {

    }


    /**
     * Return info about model by model-key
     *
     * @param $modelKey
     * @return DeviceModelData
     * @throws SwitcherCoreApiServerErrors
     * @throws SwitcherCoreException
     */
    function getModelByKey($modelKey)
    {
        $curl = new Curl();
        $curl->setDefaultJsonDecoder($assoc = true);
        $curl->setHeader('Content-Type', 'application/json');
        $curl->setTimeout($this->requestTimeoutSec);
        $curl->get($this->swCoreAddr . '/model/' . $modelKey);
        if (isset($curl->response['error'])) {
            throw new SwitcherCoreException($curl->response['error']['description']);
        } elseif ($curl->error) {
            throw new SwitcherCoreApiServerErrors($curl->error->errorMessage, $curl->error->errorCode);
        };
        return DeviceModelData::initFromArray($curl->response['data']);
    }

    /**
     * @param Device $device
     * @return DeviceModelData
     * @throws SwitcherCoreApiServerErrors
     * @throws SwitcherCoreException
     */
    function detectByDevice(Device $device)
    {
        $curl = new Curl();
        $curl->setDefaultJsonDecoder($assoc = true);
        $curl->setHeader('Content-Type', 'application/json');
        $curl->setTimeout($this->requestTimeoutSec);
        $curl->post($this->swCoreAddr . '/detect', $device->getAsArray());
        if (isset($curl->response['error'])) {
            throw new SwitcherCoreException($curl->response['error']['description']);
        } elseif ($curl->error) {
            throw new SwitcherCoreApiServerErrors($curl->error->errorMessage, $curl->error->errorCode);
        };

        return DeviceModelData::initFromArray($curl->response['data']);
    }

}