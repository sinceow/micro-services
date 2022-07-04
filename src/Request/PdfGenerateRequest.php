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

class PdfGenerateRequest implements MsRequest
{


    const RESOURCE_TYPE_RAW = 'raw'; //从原始内容生成 PDF
    const RESOURCE_TYPE_URL = 'url'; //从 URL 生成 PDF
    const RESOURCE_TYPE_FILE = 'file';//上传文件生成 PDF


    private $_files = [];


    /**
     * 生成 PDF 的模板类型
     * @var string
     */
    private $type = self::RESOURCE_TYPE_RAW;

    /**
     * 生成 PDF 的内容，需与 $type 相对应
     * @var string
     */
    private $resource = '';

    /**
     * @var string 用于大文件生成后的回调
     */
    private $callback = '';

    /**
     * @var bool 是否开启调试，调试情况下不会进行IP检测
     */
    private $debug = false;

    private $api_params = [];


    public function setType($type)
    {
        $this->type = $type;
        $this->api_params['type'] = $type;

        if ($type === self::RESOURCE_TYPE_FILE && !count($this->_files) && $this->resource) {
            $this->_files[] = $this->resource;
        }
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getResource()
    {
        return $this->resource;
    }

    public function setResource($resource)
    {
        if ($this->type === self::RESOURCE_TYPE_FILE) {
            $this->_files[] = $resource;
        } else {
            $this->resource = $resource;
            $this->api_params['resource'] = $resource;
        }
    }

    public function setCallback($callback)
    {
        $this->callback = $callback;
        $this->api_params['callback'] = $callback;
    }

    public function getCallback(): string
    {
        return $this->callback;
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
        return 'api/service/pdf/generate';
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
        if (RequestCheckUtil::checkEmpty($this->_files) && RequestCheckUtil::checkEmpty($this->resource)) {
            throw new Exception("client-check-error:Invalid Arguments: must pass url or file", 41);
        }
    }
}