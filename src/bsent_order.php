<?php
    //====================================
    // 商家寄件下单接口
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================
    
    // 参数设置
    $key = '';                         // 客户授权key
    $secret = '';                      // 客户授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (
        'kuaidicom' => '',              // 快递公司的编码
        'recManName' => '',             // 收件人姓名
        'recManMobile' => '',           // 收件人手机号
        'recManPrintAddr' => '',        // 收件人所在完整地址
        'sendManName' => '',            // 寄件人姓名
        'sendManMobile' => '',          // 寄件人的手机号
        'sendManPrintAddr' => '',       // 寄件人所在的完整地址
        'callBackUrl' => '',            // callBackUrl订单信息回调，默认仅支持http
        'cargo' => '',                  // 物品名称
        'payment' => 'SHIPPER',         // 支付方式，SHIPPER: 寄付（默认）。不支持到付
        'serviceType' => '标准快递',    // 业务类型，默认为标准快递，各快递公司业务类型对照参考：七、业务类型参数表
        'weight' => '0.5',              // 物品总重量KG，不需带单位
        'remark' => '测试',             // 备注
        'salt' => '',                   // 签名用随机字符串
        'dayType' => '今天',            // 预约日期，例如：今天/明天/后天
        'pickupStartTime' => '',        // 预约起始时间（HH:mm），例如：09:00
        'pickupEndTime' => '',          // 预约截止时间（HH:mm），例如：10:00
        'valinsPay' => null,            // 保价额度，单位：元
        'passwordSigning' => 'N',       // 是否口令签收，Y：需要 N: 不需要
        'op' => '0',                    // 是否开启订阅功能 0：不开启(默认) 1：开启
        'pollCallBackUrl' => null,      // 如果op设置为1时，pollCallBackUrl必须填入，用于跟踪回调
        'resultv2' => '0',              // 此字段表示开通行政区域解析或地图轨迹功能
        'returnType' => null,           // 面单返回类型，默认为空
        'siid' => null,                 // 设备码
        'tempid' => null,               // 模板编码
        'printCallBackUrl' => null      // 打印状态回调地址
    );
    
    // 请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);

    $url = 'https://poll.kuaidi100.com/order/borderapi.do?method=bOrder';    // 商家寄件下单接口地址
    
echo '请求参数：<br/><pre>';
echo print_r($post_data);
echo '</pre>';
    
    //发送post请求
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    $result = curl_exec($ch);
    $data = json_decode($result, true);

echo '<br/><br/>返回数据：<br/><pre>';
echo print_r($data);
//echo var_dump($data);
echo '</pre>';
?>