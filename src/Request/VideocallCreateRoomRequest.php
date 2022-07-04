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

class VideocallCreateRoomRequest implements MsRequest
{

    /**
     * @var string 主叫方称呼
     *
     */
    private string $user_name = '';


    /**
     * @var string 被叫方称呼
     *
     */
    private string $remote_user_name = '';

    /**
     * @var string 由API调用方自定义的附加字段，
     *             会在回调中以及获取通话房间中原样返回
     *
     */
    private string $extra = '';

    /**
     * @var bool 是否开启调试，调试情况下不会进行IP检测
     */
    private bool $debug = false;

    private array $api_params = [];


    /**
     * @param string $user_name
     */
    public function setUserName(string $user_name): void
    {
        $this->user_name = $user_name;
        $this->api_params['user_name'] = $user_name;
    }

    /**
     * @return string
     */
    public function getUserName(): string
    {
        return $this->user_name;
    }

    /**
     * @param string $remote_user_name
     */
    public function setRemoteUserName(string $remote_user_name): void
    {
        $this->remote_user_name = $remote_user_name;
        $this->api_params['remote_user_name'] = $remote_user_name;
    }

    /**
     * @return string
     */
    public function getRemoteUserName(): string
    {
        return $this->remote_user_name;
    }


    public function setExtra($extra)
    {
        $this->extra = $extra;
        $this->api_params['extra'] = $extra;
    }


    public function getExtra(): string
    {
        return $this->extra;
    }


    public function setDebug($debug)
    {
        $this->debug = $debug;
        $this->api_params['debug'] = $debug;
    }

    public function getDebug(): bool
    {
        return $this->debug;
    }

    public function getApiMethodName(): string
    {
        return 'api/service/videocall/create_room';
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
        if (RequestCheckUtil::checkEmpty($this->user_name)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of user_name is empty", 41);
        }

        if (RequestCheckUtil::checkEmpty($this->remote_user_name)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of remote_user_name is empty", 41);
        }
    }
}