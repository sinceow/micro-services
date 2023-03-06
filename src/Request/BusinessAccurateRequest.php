<?php
/*======================================================================
*
*   Copyright (C) 2014-2018 广州啪嗒信息科技有限公司
*   All rights reserved
*
*   Project     : micro-services
*   Author      : sinceow
*   Time        : 2018/5/29 下午5:48
*   Description : 
*   Copyright   : http://www.padakeji.com
*
*   Powered by http://www.padakeji.com
=========================================================================*/

namespace Jobsys\MicroServices\Request;

use Exception;
use Jobsys\MicroServices\RequestCheckUtil;

class BusinessAccurateRequest implements  MsRequest{

    /**
     * @var string 查询公司关键词
     */
    private $keyword = '';

    /**
     * @var bool 是否开启调试，调试情况下不会进行IP检测
     */
    private $debug = false;

    private $api_params = [];


    public function setKeyword($keyword){
        $this->keyword = $keyword;
        $this->api_params['keyword'] = $keyword;
    }

    public function getKeyword(): string
    {
        return $this->keyword;
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
        return 'api/service/business/accurate';
    }

    public function getApiParams(): array
    {
        return $this->api_params;
    }

    public function getResponseType(): string
    {
        return "json";
    }

    /**
     * @throws Exception
     */
    public function check()
    {
        if (RequestCheckUtil::checkEmpty($this->keyword)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of keyword is empty", 41);
        }
    }
}