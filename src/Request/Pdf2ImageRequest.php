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

class Pdf2ImageRequest implements MsRequest
{


    const FORMAT_JPEG = 'jpeg';
    const FORMAT_PNG = 'png';


    private $_files = [];


    /**
     * 生成图片格式
     * @var string
     */
    private $format = self::FORMAT_JPEG;

    /**
     * 生成图片分辨率
     * @var string
     */
    private $resolution = '300';


    /**
     * 文件路径
     * @var string
     */
    private $file = '';


    /**
     * @var bool 是否开启调试，调试情况下不会进行IP检测
     */
    private $debug = false;

    private $api_params = [];

    public function setFile($file)
    {
        $this->_files[] = $file;
    }

    public function getFile()
    {
        return count($this->_files) ? $this->_files[0] : '';
    }


    public function setResolution($resolution)
    {
        $this->resolution = $resolution;
        $this->api_params['resolution'] = $resolution;
    }

    public function getResolution(): string
    {
        return $this->resolution;
    }


    public function setFormat($format)
    {
        $this->format = $format;
        $this->api_params['format'] = $format;
    }

    public function getFormat(): string
    {
        return $this->format;
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
        return 'api/service/pdf/to_image';
    }

    public function getApiParams(): array
    {
        return $this->api_params;
    }

    public function _getFiles(): array
    {
        return $this->_files;
    }

    /**
     * @throws Exception
     */
    public function check()
    {
        if (RequestCheckUtil::checkEmpty($this->_files)) {
            throw new Exception("client-check-error:Invalid Arguments: must pass url or file", 41);
        }
    }

    public function getResponseType(): string
    {
        return "compress";
    }
}