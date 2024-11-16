<?php

namespace Meklis\SwCoreClient;

use Curl\Curl;
use Curl\MultiCurl;
use Meklis\SwCoreClient\Exceptions\SwitcherCoreApiServerErrors;
use Meklis\SwCoreClient\Exceptions\SwitcherCoreException;
use Meklis\SwCoreClient\Objects\Device;
use Meklis\SwCoreClient\Objects\DeviceConnectionMetaData;
use Meklis\SwCoreClient\Objects\DeviceModelData;
use Meklis\SwCoreClient\Objects\ModuleData;
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
            throw new SwitcherCoreException($response['error']['description'], 500, null, $response['error']['trace']);
        } elseif ($curl->errorMessage) {
            throw new SwitcherCoreApiServerErrors($curl->errorMessage, $curl->errorCode);
        };
        $curl->close();
        $curl = null;
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
        } elseif ($curl->errorMessage) {
            throw new SwitcherCoreApiServerErrors($curl->errorMessage, $curl->errorCode);
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
                    if (isset($response['request']['module'])) {
                        $request->setModule($response['request']['module']);
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
        $curl->close();
        $curl = null;
        return $responses;
    }

    /**
     * @param Request[] $reqs
     * @return Response[]
     */
    function callMulti(array $reqs)
    {
        $mcurl = new MultiCurl();
        $mcurl->setConcurrency($this->requestConcurrency);
        $mcurl->setTimeout($this->requestTimeoutSec);
        $mcurl->setJsonDecoder(function ($resp) {
            return json_decode($resp, true);
        });
        $responses = [];


        $requests = [];
        foreach ($reqs as $request) {
            $requests[$request->getDevice()->getIp()][] = $request;
        }


        foreach ($requests as $request) {
            $curl = new Curl();
            $curl->setTimeout($this->requestTimeoutSec);
            $curl->setHeader('Content-Type', 'application/json');
            $curl->setUrl($this->swCoreAddr . '/call-batch');
            $curl->setOpt(CURLOPT_POST, true);
            $curl->setOpt(CURLOPT_POSTFIELDS, $curl->buildPostData(array_map(function ($e) {return $e->getAsArray();}, $request)));
            $req = $mcurl->addCurl($curl);
            $requestsHash = [];
            foreach ($request as $reqH) {
                $args = $reqH->getArguments();
                ksort($args);
                $requestsHash["{$reqH->getDevice()->getIp()}:{$reqH->getModule()}:".md5(json_encode($args))] = $reqH;
            }
            $req->req = $requestsHash;
        }
        $mcurl->success(function ($instance) use (&$responses) {
            if(!isset($instance->response['data'])) {
                throw new \Exception("Error Processing Request", 1);
            }
            foreach ($instance->response['data'] as $resp) {
                $args = $resp['request']['arguments'];
                ksort($args);
                $hash = "{$resp['request']['device']['ip']}:{$resp['request']['module']}:".md5(json_encode($args));
                if(!isset($instance->req[$hash])) {
                    throw new \Exception("Cannot find request by $hash");
                }
                $response = (new Response())
                    ->setRequest($instance->req[$hash]);
                if(isset($resp['data'])) {
                    $response->setResponse($resp['data']);
                }
                if(isset($resp['error'])) {
                    $response->setError(new SwitcherCoreApiServerErrors($resp['error']['message']));
                }
                $responses[] = $response;
            }
            $instance = null;
        });
        $mcurl->error(function ($instance) use (&$responses) {
            foreach ($instance->req as $req) {
                $response = (new Response())
                    ->setRequest($req);
                if(isset($instance->response['error'])) {
                    $response->setError(new SwitcherCoreApiServerErrors($instance->response['error']['description'], $instance->errorCode, null, $instance->response['error']['trace']));
                } elseif ($instance->errorMessage) {
                    $response->setError(new SwitcherCoreApiServerErrors($instance->errorMessage, $instance->errorCode));
                }
                $responses[] = $response;
            }
            $instance = null;
        });
        $mcurl->start();
        $mcurl->close();
        $mcurl = null;
        return $responses;
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
        } elseif ($curl->errorMessage) {
            throw new SwitcherCoreApiServerErrors($curl->errorMessage, $curl->errorCode);
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
        } elseif ($curl->errorMessage) {
            throw new SwitcherCoreApiServerErrors($curl->errorMessage, $curl->errorCode);
        };

        return DeviceModelData::initFromArray($curl->response['data']);
    }

    function getModulesList() {
        $curl = new Curl();
        $curl->setDefaultJsonDecoder($assoc = true);
        $curl->setHeader('Content-Type', 'application/json');
        $curl->setTimeout($this->requestTimeoutSec);
        $curl->get($this->swCoreAddr . '/modules');
        if (isset($curl->response['error'])) {
            throw new SwitcherCoreException($curl->response['error']['description']);
        } elseif ($curl->errorMessage) {
            throw new SwitcherCoreApiServerErrors($curl->errorMessage, $curl->errorCode);
        };
        $modules = [];
        foreach ($curl->response['data'] as $d) {
            $modules[] = ModuleData::init($d['name'], $d['arguments'], $d['description']);
        }
        return $modules;
    }

}