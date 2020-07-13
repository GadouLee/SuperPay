<?php
// Autoload 自动载入
require '../vendor/autoload.php';
// 当返回错误码为“SYSTEMERROR”时，请不要更换商户订单号，一定要使用原商户订单号重试，否则可能造成重复支付等资金风险。
// 请商户在自身的系统中合理设置付款频次并做好并发控制，防范错付风险。
// 证书放置路径为:/cert/apiclient_cert.pem,/cert/apiclient_key.pem
$baseData = [
    'mch_appid' => '',  //申请商户号的appid或商户号绑定的appid
    'mchid'     => '',  //微信支付分配的商户号
    'pay_key'   => '',  //微信支付key
];
$obj = new SuperPay\Init($baseData);

$data = [
    'class_type_name'   =>  'TransferAccounts', // 操作类型：TransferAccounts 提现
    'class_name'        =>  'Wechat',           // 要调用的类名支持：Wechat
    'device_info'       =>  '',                 // 设备号,选填，微信支付分配的终端设备号
    'partner_trade_no'  =>  '',                 // 订单号商户订单号，需保持唯一性(只能是字母或者数字，不能包含有其它字符)
    'openid'            =>  '',                 // 用户openid
    'check_name'        =>  '',                 // 校验用户姓名选项 NO_CHECK：不校验真实姓名 FORCE_CHECK：强校验真实姓名
    're_user_name'      =>  '',                 // 收款用户真实姓名。如果check_name设置为FORCE_CHECK，则必填用户真实姓名
    'amount'            =>  '',                 // 企业付款金额，单位为分
    'desc'              =>  '',                 // 企业付款备注，必填。注意：备注中的敏感词会被转成字符*
];
$obj->query($data);