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

class VideocallCallingRoomRequest implements MsRequest
{

    /**
     * @var string 按extra信息进行查询
     *
     */
    private string $extra = '';

    /**
     * @var string extra 信息的查询模式，可选 'like', 'equal'
     *             like: 模糊查询; equal: 精确查询
     *
     */
    private string $rule = '';


    /**
     * @var string room_id 按通话房间号查询
     */
    private string $room_id = '';


    /**
     * @var bool 是否开启调试，调试情况下不会进行IP检测
     */
    private bool $debug = false;


    private array $api_params = [];

    public function setRoomId($room_id)
    {
        $this->room_id = $room_id;
        $this->api_params['room_id'] = $room_id;
    }

    public function getRoomId(): string
    {
        return $this->room_id;
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

    public function setRule($rule)
    {
        $this->rule = $rule;
        $this->api_params['rule'] = $rule;
    }

    public function getRule(): string
    {
        return $this->rule;
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
        return 'api/service/videocall/calling_room';
    }

    public function getApiParams(): array
    {
        return $this->api_params;
    }

    public function check()
    {
    }
}