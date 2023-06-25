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

class PassportPhotoDetectRequest implements  MsRequest{

    /**
     * @var int 证件照规格ID
     * @see https://www.zjzapi.com/site/item.html
     */
    private $item_id = '';

    /**
     * @var string 证件照 base64 编码
     */
    private $image = '';

    /**
     * @var bool 是否开启调试，调试情况下不会进行IP检测
     */
    private $debug = false;

    private $api_params = array();


    public function setItemId($item_id){
        $this->item_id = $item_id;
        $this->api_params['item_id'] = $item_id;
    }

    public function getItemId(): string
    {
        return $this->item_id;
    }

    public function setImage($image){
        $this->image = $image;
        $this->api_params['image'] = $image;
    }

    public function getImage(): string
    {
        return $this->image;
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
        return 'api/service/passport_photo_detect/query';
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
        if (RequestCheckUtil::checkEmpty($this->item_id)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of item_id is empty", 41);
        }

        if (RequestCheckUtil::checkEmpty($this->image)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of image is empty", 41);
        }
    }

    public function getResponseType(): string
    {
        return "json";
    }
}