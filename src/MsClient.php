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


namespace Jobsys\MicroServices;

use Exception;
use Jobsys\MicroServices\Request\AuthRequest;
use Jobsys\MicroServices\Request\MsRequest;

class MsClient
{

    const STATE_SUCCESS = 'SUCCESS';
    const STATE_FAIL = 'FAIL';

    protected static ?self $client = null;

    public string $format = "json";

    public int $connect_timeout = 300;

    public int $read_timeout = 0;

    private $server_url = "https://msv8.jobsys.cn/public/index.php/";

    public bool $check_request = true;

    protected string $api_version = "2.0";

    protected string $sdk_version = "ms-sdk-php-20220527";

    private ?string $token = null;

    public static function getInstance(string $app_id, string $app_secret): MsClient
    {

        if (is_null(self::$client)) {
            self::$client = new MsClient();
        }

        if (!self::$client->getToken()) {
            $request = new AuthRequest($app_id, $app_secret);
            $result = self::$client->execute($request);
            if (isset($result['result']['access_token'])) {
                self::$client->setToken($result['result']['access_token']);
            }
        }
        return self::$client;
    }


    public function curl($url, $post_fields = [], $res_type = 'json'): bool|string
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_FAILONERROR, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        if ($this->read_timeout) {
            curl_setopt($ch, CURLOPT_TIMEOUT, $this->read_timeout);
        }
        if ($this->connect_timeout) {
            curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $this->connect_timeout);
        }
        curl_setopt($ch, CURLOPT_USERAGENT, "ms-sdk-php");
        //https 请求
        if (strlen($url) > 5 && strtolower(substr($url, 0, 5)) == "https") {
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        }

        if (!empty($post_fields)) {
            $header = ["content-type: multipart/form-data; charset=UTF-8"];
            if ($this->token) {
                $header[] = 'Authorization: Bearer ' . $this->token;
            }


            $post_data = [];

            //为了兼容文件发送， 不能直接使用 http_build_query，手动将数组转成 URL 形式
            foreach ($post_fields as $key => $value) {
                if (is_array($value)) {
                    foreach ($value as $index => $item) {
                        $post_data[$key . '[' . $index . ']'] = $item;
                    }
                } else {
                    $post_data[$key] = $value;
                }
            }

            curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }

        if ($res_type === 'file') {
            $temp_file = tempnam(sys_get_temp_dir(), 'Ms');
            $fp = fopen($temp_file, 'w');
            curl_setopt($ch, CURLOPT_FILE, $fp);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        }


        $response = curl_exec($ch);

        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch), 0);
        } else {
            $http_status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $http_status_code) {
                throw new Exception($response, $http_status_code);
            }
        }
        curl_close($ch);
        if ($res_type === 'file') {
            fclose($fp);
            return $temp_file;
        } else {
            return $response;
        }
    }


    protected function logCommunicationError($api_name, $request_url, $error_code, $response_txt): void
    {
        $local_ip = isset($_SERVER["SERVER_ADDR"]) ? $_SERVER["SERVER_ADDR"] : "CLI";
        $logger = new MsLogger();
        $logger->conf["log_file"] = rtrim('/tmp/', '\\/') . '/' . "logs/ms_comm_err_" . date("Y-m-d") . ".log";
        $logger->conf["separator"] = "^_^";
        $logData = array(
            date("Y-m-d H:i:s"),
            $api_name,
            $local_ip,
            PHP_OS,
            $this->sdk_version,
            $request_url,
            $error_code,
            str_replace("\n", "", $response_txt)
        );
        $logger->log($logData);
    }

    /**
     * @param MsRequest $request
     * @return mixed|array
     */
    public function execute(MsRequest $request): mixed
    {
        $result = new ResultSet();
        if ($this->check_request) {
            try {
                $request->check();
            } catch (Exception $e) {
                $result->status = $e->getCode();
                $result->result = $e->getMessage();
                return json_encode($result);
            }
        }
        //组装系统参数
        $sys_params["v"] = $this->api_version;
        $sys_params["format"] = $this->format;
        $sys_params["timestamp"] = date("Y-m-d H:i:s");


        //获取业务参数
        $api_params = $request->getApiParams();
        if (method_exists($request, '_getFiles')) {
            $files = $request->_getFiles();
            if (count($files) > 0) {
                foreach ($files as $index => $file) {
                    $api_params["file" . $index] = curl_file_create($file);
                }
            }
        }


        //系统参数放入GET请求串
        $request_url = $this->server_url . $request->getApiMethodName() . "?";

        foreach ($sys_params as $sys_param_key => $sys_param_value) {
            $request_url .= "$sys_param_key=" . urlencode($sys_param_value) . "&";
        }

        $request_url = substr($request_url, 0, -1);

        //发起HTTP请求
        try {
            $resp = $this->curl($request_url, $api_params, $request->getResponseType());
        } catch (Exception $e) {
            $this->logCommunicationError($request->getApiMethodName(), $request_url, "HTTP_ERROR_" . $e->getCode(), $e->getMessage());
            $result->status = $e->getCode();
            $result->result = $e->getMessage();
            return json_encode($result);
        }

        unset($api_params);

        //解析MS返回结果


        if ($request->getResponseType() === 'json') {
            //否则当成 JSON 处理
            $resp_well_formed = false;
            $resp_object = json_decode($resp);
            if (null !== $resp_object) {
                $resp_well_formed = true;
                $result->status = $resp_object->status;
                $result->result = $resp_object->result;
            }

            //返回的HTTP文本不是标准JSON，记下错误日志
            if (false === $resp_well_formed) {
                $this->logCommunicationError($request->getApiMethodName(), $request_url, "HTTP_RESPONSE_NOT_WELL_FORMED", $resp);
                $result->status = self::STATE_FAIL;
                $result->result = "HTTP_RESPONSE_NOT_WELL_FORMED";
                return json_encode($result);
            }
        } else if ($request->getResponseType() === 'file') {
            return $resp;
        }


        //如果MS返回了错误码，记录到业务错误日志中
        if (isset($resp_object->status) && $resp_object->status != self::STATE_SUCCESS) {
            $logger = new MsLogger;
            $logger->conf["log_file"] = rtrim('/tmp/', '\\/') . '/' . "logs/ms_biz_err_" . date("Y-m-d") . ".log";
            $logger->log(array(
                date("Y-m-d H:i:s"),
                $resp_object->result
            ));
        }
        return json_decode(json_encode($result), true);
    }

    public function setToken($token): void
    {
        $this->token = $token;
    }

    public function getToken(): string|null
    {
        return $this->token;
    }
}