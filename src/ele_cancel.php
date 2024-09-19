<?php
    //====================================
    // 电子面单取消接口示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $secret = '';                          // 授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (
        'partnerId' => '',                 // 电子面单客户账户或月结账号
        'partnerKey' => '',                // 电子面单密码
        'partnerSecret' => '',             // 电子面单密钥
        'partnerName' => '',               // 电子面单客户账户名称
        'net' => '',                       // 收件网点名称,由快递公司当地网点分配
        'code' => '',                      // 电子面单承载编号
        'kuaidicom' => '',                 // 快递公司的编码：https://api.kuaidi100.com/document/5f0ff6e82977d50a94e10237.html
        'kuaidinum' => '',                 // 快递单号
        'orderId' => '',                   // 快递公司订单号，对应下单时返回的kdComOrderNum，如果下单时有返回该字段，则取消时必填，否则可以不填
        'reason' => ''                     // 取消原因
    );
    
    // 请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://api.kuaidi100.com/label/order?method=cancel';    // 电子面单取消请求地址
    
echo '请求参数：<br/><pre>';
echo print_r($post_data);
echo '</pre>';
    
    // 发送post请求
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
