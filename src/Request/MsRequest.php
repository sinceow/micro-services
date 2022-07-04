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

interface MsRequest
{

    public function getApiMethodName();

    public function getApiParams();

    public function check();
}