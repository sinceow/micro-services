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

class LivePlayRequest implements MsRequest
{

    /**
     * @var string 流名称（确保唯一）
     */
    private string $stream_name = '';

    /**
     * @var int 结束时间 (10位时间戳格式)
     */
    private int $lh_ended_at = 0;

    /**
     * @var int 开始时间 (10位时间戳格式)
     */
    private int $lh_started_at = 0;

    /**
     * @var string 直播标题
     */
    private string $lh_title = '';

    /**
     * @var string 主播名称
     */
    private string $lh_author = '';


    /**
     * @var string 直播描述
     */
    private string $lh_description = '';


    /**
     * @var string 附加信息
     */
    private string $lh_extra = '';


    /**
     * @var bool 是否开启调试，调试情况下不会进行IP检测
     */
    private bool $debug = false;

    private array $api_params = [];


    /**
     * @return string
     */
    public function getStreamName(): string
    {
        return $this->stream_name;
    }


    public function setStreamName($stream_name): void
    {
        $this->stream_name = $stream_name;
        $this->api_params['stream_name'] = $stream_name;
    }


    public function getLhEndedAt(): int
    {
        return $this->lh_ended_at;
    }

    /**
     * @param int $lh_ended_at
     */
    public function setLhEndedAt(int $lh_ended_at): void
    {
        $this->lh_ended_at = $lh_ended_at;
        $this->api_params['lh_ended_at'] = $lh_ended_at;
    }


    public function getLhStartedAt(): int
    {
        return $this->lh_started_at;
    }

    /**
     * @param int $lh_started_at
     */
    public function setLhStartedAt(int $lh_started_at): void
    {
        $this->lh_started_at = $lh_started_at;
        $this->api_params['lh_started_at'] = $lh_started_at;
    }


    /**
     * @return string
     */
    public function getLhTitle(): string
    {
        return $this->lh_title;
    }


    /**
     * @param string $lh_title
     */
    public function setLhTitle(string $lh_title): void
    {
        $this->lh_title = $lh_title;
        $this->api_params['lh_title'] = $lh_title;
    }

    /**
     * @return string
     */
    public function getLhAuthor(): string
    {
        return $this->lh_author;
    }

    /**
     * @param string $lh_author
     */
    public function setLhAuthor(string $lh_author): void
    {
        $this->lh_author = $lh_author;
        $this->api_params['lh_author'] = $lh_author;

    }


    /**
     * @return string
     */
    public function getLhDescription(): string
    {
        return $this->lh_description;
    }

    /**
     * @param string $lh_description
     */
    public function setLhDescription(string $lh_description): void
    {
        $this->lh_description = $lh_description;
        $this->api_params['lh_description'] = $lh_description;
    }


    /**
     * @return string
     */
    public function getLhExtra(): string
    {
        return $this->lh_extra;
    }

    /**
     * @param string $lh_extra
     */
    public function setLhExtra(string $lh_extra): void
    {
        $this->lh_extra = $lh_extra;
        $this->api_params['lh_extra'] = $lh_extra;
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
        return 'api/service/live/play';
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

        if (RequestCheckUtil::checkEmpty($this->lh_ended_at)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of lh_ended_at is empty", 41);
        }

        if (RequestCheckUtil::checkEmpty($this->lh_started_at)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of lh_started_at is empty", 41);
        }

        if (RequestCheckUtil::checkEmpty($this->lh_title)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of lh_title is empty", 41);
        }

        if($this->lh_ended_at - $this->lh_started_at > 24 * 60 * 60){
            throw new Exception("client-check-error:Over 24 hours limit", 41);
        }
    }

    public function getResponseType(): string
    {
        return "json";
    }
}