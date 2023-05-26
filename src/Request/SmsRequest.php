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

class SmsRequest implements MsRequest
{

    /**
     * 验证码${code}，您正在参加${product}的${item}活动，请确认系本人申请。
     */
    const SMS_TYPE_ACTIVITY_CODE = 'ACTIVITY_CODE'; //活动验证

    /**
     * 验证码${code}，您正在进行${product}身份验证，打死不要告诉别人哦！
     */
    const SMS_TYPE_CHECK_CODE = 'CHECK_CODE'; //变更验证

    /**
     *验证码${code}，您正在登录${product}，若非本人操作，请勿泄露。
     */
    const SMS_TYPE_LOGIN_CODE = 'LOGIN_CODE'; //登录验证

    /**
     * 验证码${code}，您正尝试异地登陆${product}，若非本人操作，请勿泄露。
     */
    const SMS_TYPE_LOGIN_EXCEPTION_CODE = 'LOGIN_EXCEPTION_CODE'; //登录异常

    /**
     * 验证码${code}，您正在注册成为${product}用户，感谢您的支持！
     */
    const SMS_TYPE_REGISTER_CODE = 'REGISTER_CODE'; //注册验证

    /**
     * 验证码${code}，您正在尝试修改${product}登录密码，请妥善保管账户信息。
     */
    const SMS_TYPE_RESET_PASSWORD_CODE = 'RESET_PASSWORD_CODE'; //重设密码

    /**
     * 尊敬的 ${name} ，您申诉 ${account} 账号找回已审核通过，新密码为：${password} - 就业中心
     */
    const SMS_TYPE_JOBSYS_ENTERPRISE_FIND_PASSWORD = 'JOBSYS_ENTERPRISE_FIND_PASSWORD'; //用人单位申诉找回密码

    /**
     * 尊敬的 ${name} 用人单位，验证码：${code}，您正在进行手机验证，请勿告诉他人 - 就业中心
     */
    const SMS_TYPE_ENTERPRISE_VALIDATE = 'JOBSYS_ENTERPRISE_VALIDATE'; //用人单位手机验证

    /**
     * 尊敬的用人单位，验证码：${code}，您正在进行账号注册，请勿告诉他人 - 就业中心
     */
    const SMS_TYPE_JOBSYS_ENTERPRISE_REGISTER = 'JOBSYS_ENTERPRISE_REGISTER'; //用人单位注册


    /**
     * 你好，验证码：${code}，您正在进行手机验证，请勿告诉他人 - 就业中心
     */
    const SMS_TYPE_JOBSYS_STUDENT_VALIDATE = 'JOBSYS_STUDENT_VALIDATE'; //学生验证


    /**
     * ${name}您好，${name1}正在邀请您进行视频通话，请点击学校公众号通知进行处理，若已处理，无需理会。
     */
    const SMS_TYPE_VIDEOCALL_WECHAT_OFFICIAL_NOTIFICATION = 'VIDEOCALL_WECHAT_OFFICIAL_NOTIFICATION'; //视频能话公众号通知


    /**
     * ${name}您好，${uni_name}提醒您：您定制的用人单位服务记录时间已到，请登录管理后台查看。如已操作，请勿理会。
     */
    const  SMS_TYPE_JOBSYS_ENTERPRISE_NOTIFICATION = 'JOBSYS_ENTERPRISE_NOTIFICATION'; //就业中心企业通知


    /**
     * ${name} 校友您好，您的校友学籍认证已通过，可前往小程序申领校友卡。
     */
    const SMS_TYPE_ALUMNI_STATUS_VERIFY_PASSED = 'ALUMNI_STATUS_VERIFY_PASSED'; //校友学籍认证审核通过


    /**
     * ${name} 校友您好，您的校友学籍认证未通过，请前往小程序查看相关原因，修正后重新提交审核。
     */
    const SMS_TYPE_ALUMNI_STATUS_VERIFY_DENIED = 'ALUMNI_STATUS_VERIFY_DENIED'; //校友学籍认证审核不通过


    /**
     * ${name} 校友您好，您的校友卡复审未通过，请前往小程序查看相关原因，修正后重新提交审核。
     */
    const SMS_TYPE_ALUMNI_CARD_VERIFY_DENIED = 'ALUMNI_CARD_VERIFY_DENIED'; //校友卡复审未通过

    /***********************************以上为短信类型设置*********************************************/


    /**
     * @var array 接收短信的号码
     */
    private $phone_nums = [];

    /**
     * @var string 短信类型
     */
    private $type = '';

    /**
     * @var array 短信模板参数
     */
    private $params = [];

    /**
     * @var bool 是否开启调试，调试情况下不会进行IP检测
     */
    private $debug = false;


    private $api_params = [];


    public function getPhoneNums(): array
    {
        return $this->phone_nums;
    }

    public function setPhoneNums($nums = [])
    {
        if (is_string($nums) || is_numeric($nums)) {
            $this->phone_nums[] = strval($nums);
        } else {
            $this->phone_nums = $nums;
        }
        $this->api_params['phone_nums'] = $this->phone_nums;
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function setType($type)
    {
        $this->type = $type;
        $this->api_params['type'] = $type;
    }


    public function getParams(): array
    {
        return $this->params;
    }

    public function setParams($params = [])
    {
        $this->params = $params;
        $this->api_params['params'] = $params;
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
        return 'api/service/sms/send';
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

        if (RequestCheckUtil::checkEmpty($this->phone_nums)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of phone_nums is empty", 41);
        }

        if (count($this->phone_nums) > 500) {
            throw new Exception("client-check-error:Invalid Arguments:the value of phone_nums is over 500", 41);
        }

        if (RequestCheckUtil::checkEmpty($this->params)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of params is empty", 41);
        }

        RequestCheckUtil::checkNotNull($this->type, 'type');
    }

    public function getResponseType(): string
    {
        return "json";
    }
}