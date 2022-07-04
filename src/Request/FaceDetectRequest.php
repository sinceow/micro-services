<?php
/*======================================================================    
*
*   Copyright (C) 2014-2018 广州啪嗒信息科技有限公司
*   All rights reserved
*
*   Project     : micro-services
*   Author      : sinceow <sinceow@163.com>
*   Time        : 2018/4/19
*   Description : 
*   Copyright   : http://www.padakeji.com
*
*   Powered by http://www.padakeji.com
=========================================================================*/

namespace Jobsys\MicroServices\Request;

use Exception;
use Jobsys\MicroServices\RequestCheckUtil;

class FaceDetectRequest implements MsRequest
{

    /**
     * @var string 参照图片 （必填）
     */
    private string $avatar_a = '';

    /**
     * @var string 比对图片（必填）
     */
    private string $avatar_b = '';

    /**
     * @var int 图片质量控制
     *
     * 0: 不进行控制；
     * 1:较低的质量要求，图像存在非常模糊，眼睛鼻子嘴巴遮挡至少其中一种或多种的情况；
     * 2: 一般的质量要求，图像存在偏亮，偏暗，模糊或一般模糊，眉毛遮挡，脸颊遮挡，下巴遮挡，至少其中三种的情况；
     * 3: 较高的质量要求，图像存在偏亮，偏暗，一般模糊，眉毛遮挡，脸颊遮挡，下巴遮挡，其中一到两种的情况；
     * 4: 很高的质量要求，各个维度均为最好或最多在某一维度上存在轻微问题；
     * 默认 0。
     * 若图片质量不满足要求，则返回结果中会提示图片质量检测不符要求。
     */
    private int $quality = 0;

    /**
     * @var boolean 是否开启图片旋转识别支持。开启后，整体耗时将可能增加数百毫秒。
     */
    private bool $rotate = false;

    /**
     * @var bool 是否开启调试，调试情况下不会进行IP检测
     */
    private bool $debug = false;


    private array $api_params = [];


    public function getAvatarA(): string
    {
        return $this->avatar_a;
    }

    public function setAvatarA($avatar_a)
    {
        $this->avatar_a = $avatar_a;
        $this->api_params['avatar_a'] = $this->avatar_a;
    }


    public function getAvatarB(): string
    {
        return $this->avatar_b;
    }

    public function setAvatarB($avatar_b)
    {
        $this->avatar_b = $avatar_b;
        $this->api_params['avatar_b'] = $this->avatar_b;
    }

    public function getQuality(): int
    {
        return $this->quality;
    }

    public function setQuality($quality)
    {
        $this->quality = $quality;
        $this->api_params['quality'] = $quality;
    }


    public function getRotate(): bool
    {
        return $this->rotate;
    }

    public function setRotate($rotate)
    {
        $this->rotate = $rotate;
        $this->api_params['rotate'] = $rotate;
    }

    public function getDebug(): bool
    {
        return $this->debug;
    }

    public function setDebug($debug)
    {
        $this->debug = $debug;
        $this->api_params['debug'] = $debug;
    }


    public function getApiMethodName(): string
    {
        return 'api/service/face_detect/detect';
    }

    public function getApiParams(): array
    {
        return $this->api_params;
    }

    /**
     * @throws Exception
     */
    public function check(): bool
    {


        if (RequestCheckUtil::checkEmpty($this->avatar_a)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of avatar_a is empty", 41);
        }

        if (RequestCheckUtil::checkEmpty($this->avatar_b)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of avatar_b is empty", 41);
        }

        return true;
    }

    public function getResponseType(): string
    {
        return "json";
    }
}