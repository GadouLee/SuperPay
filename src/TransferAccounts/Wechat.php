<?php
namespace SuperPay\TransferAccounts;

use SuperPay;

class Wechat extends SuperPay\WechatBase implements Commit
{
    protected $param = [];
    /**
     *  @param mch_appid        是
     *  @param appid            是 申请商户号的appid或商户号绑定的appid
     *  @param mchid            是 微信支付分配的商户号
     */
    public function __construct($param)
    {
        $this->param = $param;
    }

    /**
     *  @param device_info      否 微信支付分配的终端设备号
     *  @param partner_trade_no 是 商户订单号，需保持唯一性(只能是字母或者数字，不能包含有其它字符)
     *  @param openid           是 商户appid下，某用户的openid
     *  @param check_name       是 NO_CHECK：不校验真实姓名 FORCE_CHECK：强校验真实姓名
     *  @param re_user_name     否 收款用户真实姓名。如果check_name设置为FORCE_CHECK，则必填用户真实姓名
     *  @param amount           是 企业付款金额，单位为分
     *  @param desc             是 企业付款备注，必填。注意：备注中的敏感词会被转成字符*
     */
    public function commit($param)
    {
        $param = array_merge($param, $this->param);

        $param['spbill_create_ip'] = $_SERVER['SERVER_ADDR'];
        $payKey                    = $param['pay_key'];
        unset($param['pay_key']);
        $param['amount']    = $param['amount'] * 100;
        $param['nonce_str'] = $this->createNoncestr();
        $param['sign']      = $this->getSign($param, $payKey);
        print_r($param);
        $xmlData = $this->arrayToXml($param);
        print_r($xmlData);
        if (!array_key_exists('openid', $param)) {
            $this->bank($xmlData);
        }
    }

    protected function bank($data)
    {
        $url    = 'https://api.mch.weixin.qq.com/mmpaysptrans/pay_bank';
        $return = $this->xmlToArray($this->postXmlCurl($data, $url, 60, true));

        print_r($return);
    }
}
