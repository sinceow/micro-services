<?php
/*======================================================================
*
*   Copyright (C) 2014-2018 广州啪嗒信息科技有限公司
*   All rights reserved
*
*   Project     : micro-services
*   Author      : sinceow
*   Time        : 2018/7/3 上午10:14
*   Description : 
*   Copyright   : http://www.padakeji.com
*
*   Powered by http://www.padakeji.com
=========================================================================*/

namespace Jobsys\MicroServices\Request;

use Exception;
use Jobsys\MicroServices\RequestCheckUtil;

class ExpressQueryRequest implements  MsRequest{

    /**
     * @var string 快递服务商代码
     */
    private string $ex_code = '';

    /**
     * @var string 快递单号
     */
    private string $ex_sn = '';

    /**
     * @var bool 是否开启调试，调试情况下不会进行IP检测
     */
    private bool $debug = false;

    private array $api_params = array();


    public function setExCode($ex_code){
        $this->ex_code = $ex_code;
        $this->api_params['ex_code'] = $ex_code;
    }

    public function getExCode(): string
    {
        return $this->ex_code;
    }

    public function setExSn($ex_sn){
        $this->ex_sn = $ex_sn;
        $this->api_params['ex_sn'] = $ex_sn;
    }

    public function getExSn(): string
    {
        return $this->ex_sn;
    }

    public function setDebug($debug){
        $this->debug = $debug;
        $this->api_params['debug'] = $debug;
    }

    public function getDebug(): bool
    {
        return $this->debug;
    }

    public function getApiMethodName(): string
    {
        return 'api/service/express/query';
    }

    public function getApiParams(): array
    {
        return $this->api_params;
    }

    /**
     * @throws Exception
     */
    public function check()
    {
        if (RequestCheckUtil::checkEmpty($this->ex_code)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of ex_code is empty", 41);
        }

        if (RequestCheckUtil::checkEmpty($this->ex_sn)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of ex_sn is empty", 41);
        }
    }

    public function getResponseType(): string
    {
        return "json";
    }
}