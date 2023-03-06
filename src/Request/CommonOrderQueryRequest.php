<?php

namespace Jobsys\MicroServices\Request;

use Exception;
use Jobsys\MicroServices\RequestCheckUtil;

class CommonOrderQueryRequest implements MsRequest
{
    /**
     * @var string 内部订单编号
     */
    private $sn = '';

    private $api_params = [];

    public function setSn($sn)
    {
        $this->sn = $sn;
        $this->api_params['sn'] = $sn;
    }

    public function getSn(): string
    {
        return $this->sn;
    }

    public function getApiMethodName(): string
    {
        return "api/open/order/query_common_order";
    }

    public function getApiParams(): array
    {
        return $this->api_params;
    }

    public function check()
    {
        if (RequestCheckUtil::checkEmpty($this->sn)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of sn is empty", 41);

        }
    }

    public function getResponseType()
    {
        return "json";
    }
}