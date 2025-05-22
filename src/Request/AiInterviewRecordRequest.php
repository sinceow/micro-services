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

class AiInterviewRecordRequest implements MsRequest
{

	/**
	 * @var string 职位名称
	 */
	private $job_name = '';

	/**
	 * @var string token
	 */
	private $token = '';

	/**
	 * @var bool 是否开启调试，调试情况下不会进行IP检测
	 */
	private $debug = false;

	private $api_params = array();


	public function setJobName($job_name)
	{
		$this->job_name = $job_name;
		$this->api_params['job_name'] = $job_name;
	}

	public function getJobName()
	{
		return $this->job_name;
	}

	public function setToken($token)
	{
		$this->token = $token;
		$this->api_params['token'] = $token;
	}

	public function getToken()
	{
		return $this->token;
	}

	public function setDebug($debug)
	{
		$this->debug = $debug;
		$this->api_params['debug'] = $debug;
	}

	public function getDebug()
	{
		return $this->debug;
	}

	public function getApiMethodName()
	{
		return 'api/service/ai_interview/record';
	}

	public function getApiParams()
	{
		return $this->api_params;
	}

	public function check()
	{
		if (RequestCheckUtil::checkEmpty($this->job_name)) {
			throw new Exception("client-check-error:Invalid Arguments:the value of question is empty", 41);
		}
		if (RequestCheckUtil::checkEmpty($this->token)) {
			throw new Exception("client-check-error:Invalid Arguments:the value of token is empty", 41);
		}
	}

	public function getResponseType(): string
	{
		return "json";
	}
}
