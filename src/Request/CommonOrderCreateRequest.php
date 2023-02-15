<?php

namespace Jobsys\MicroServices\Request;

use Exception;
use Jobsys\MicroServices\MsClient;
use Jobsys\MicroServices\RequestCheckUtil;

class CommonOrderCreateRequest implements MsRequest
{

    /**
     * @var string 内部订单编号
     */
    private string $sn = '';

    /**
     * @var string 商品名称
     */
    private string $name = '';

    /**
     * @var int 商品数量
     */
    private int $count = 1;

    /**
     * @var float 商品单价
     */
    private float $price = 0.00;


    /**
     * @var float 商品总价
     */
    private float $amount = 0.00;


    /**
     * @var array 订单附加信息
     */
    private array $extra = [];


    private array $api_params = ['type' => 'common_order'];

    public function setSn($sn)
    {
        $this->sn = $sn;
        $this->api_params['sn'] = $sn;
    }

    public function getSn(): string
    {
        return $this->sn;
    }

    public function setName($name)
    {
        $this->name = $name;
        $this->api_params['name'] = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setCount($count)
    {
        $this->count = $count;
        $this->api_params['count'] = $count;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setPrice($price)
    {
        $this->price = $price;
        $this->api_params['price'] = $price;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setAmount($amount)
    {
        $this->amount = $amount;
        $this->api_params['amount'] = $amount;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function setExtra($extra)
    {
        $this->extra = $extra;
        $this->api_params['extra'] = $extra;
    }

    public function getExtra(): array
    {
        return $this->extra;
    }


    public function getApiMethodName()
    {
        return 'api/service/common_order/create';
    }

    public function getApiParams()
    {
        return $this->api_params;
    }

    public function check()
    {
        if (RequestCheckUtil::checkEmpty($this->sn)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of sn is empty", 41);
        }
        if (RequestCheckUtil::checkEmpty($this->name)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of name is empty", 41);
        }
        if (RequestCheckUtil::checkEmpty($this->count)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of count is empty", 41);
        }
        if (RequestCheckUtil::checkEmpty($this->price)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of price is empty", 41);
        }
        if (RequestCheckUtil::checkEmpty($this->amount)) {
            throw new Exception("client-check-error:Invalid Arguments:the value of amount is empty", 41);
        }

    }

    public function getResponseType(): string
    {
        return "json";
    }

    public function generatePaymentURL(MsClient $client, string $prepay_order_sn): string
    {
        return $client->getServerUrl() . 'open/confirm-prepay?prepay_order_sn=' . $prepay_order_sn;
    }
}