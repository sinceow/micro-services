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

class VideocallRoomRequest implements MsRequest
{


    /**
     * @var string 根据房间号查询通话信息
     *              使用逗号分隔','
     */
    private string $room_ids = '';

    private array $api_params = array();


    /**
     * @return string
     */
    public function getRoomIds(): string
    {
        return $this->room_ids;
    }

    /**
     * @param string $room_ids
     */
    public function setRoomIds(string $room_ids): void
    {
        $this->room_ids = $room_ids;
        $this->api_params['room_ids'] = $room_ids;
    }


    public function getApiMethodName(): string
    {
        return 'api/service/videocall/room';
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
        if (RequestCheckUtil::checkEmpty($this->room_ids)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of room_ids is empty", 41);
        }
    }

    public function getResponseType(): string
    {
        return "json";
    }
}