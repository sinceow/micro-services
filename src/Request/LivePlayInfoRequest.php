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

class LivePlayInfoRequest implements MsRequest
{

    /**
     * @var string 流名称
     */
    private string $stream_name = '';


    private array $api_params = array();

    /**
     * @return string
     */
    public function getStreamName(): string
    {
        return $this->stream_name;
    }

    /**
     * @param string $stream_name
     */
    public function setStreamName(string $stream_name): void
    {
        $this->stream_name = $stream_name;
        $this->api_params['stream_name'] = $stream_name;
    }


    public function getApiMethodName(): string
    {
        return 'api/service/live/play/info';
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
        if (RequestCheckUtil::checkEmpty($this->stream_name)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of stream_name is empty", 41);
        }
    }

    public function getResponseType(): string
    {
        return "json";
    }
}