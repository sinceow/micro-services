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

class ExpressCodeRequest implements  MsRequest{

    /**
     * @var string 快递服务商名称
     */
    private string $ex_name = '';

    private array $api_params = array();

    public function setExName($ex_name){
        $this->ex_name = $ex_name;
        $this->api_params['ex_name'] = $ex_name;
    }

    public function getExName(): string
    {
        return $this->ex_name;
    }

    public function getApiMethodName(): string
    {
        return 'api/service/express/code';
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
        if (RequestCheckUtil::checkEmpty($this->ex_name)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of ex_name is empty", 41);
        }
    }

    public function getResponseType(): string
    {
        return "json";
    }
}