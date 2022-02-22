<?php
    //====================================
    // 订单导入快递单号回传及订单发货示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/page/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $secret = '';                          // 授权secret
    $param = array (
        'shopType' => '',                  // 店铺类型，TAOBAO：淘宝，JINGDONG：京东，TOUTIAO：抖店，PINDUODUO：拼多多
        'shopId' => '',                    // 店铺ID
        'orderNum' => '',                  // 订单号，需要填写正确，否则会被电商平台的风控系统拦截
        'kuaidiCom' => '',                 // 快递公司编码，需要填写正确，否则会被电商平台的风控系统拦截
        'kuaidiNum' => ''                  // 快递单号，需要填写正确，否则会被电商平台的风控系统拦截
    );
    
    // 请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $sign = md5($post_data['param'].$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://api.kuaidi100.com/ent/logistics/send';    // 订单导入快递单号回传及订单发货请求地址
    
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
