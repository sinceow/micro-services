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

class UsageRequest implements MsRequest
{

    public function getApiMethodName(): string
    {
        return 'api/service/account/usage';
    }

    public function getApiParams(): array
    {
        return [];
    }

    /**
     * @throws Exception
     */
    public function check()
    {
    }

    public function getResponseType(): string
    {
        return "json";
    }
}