<?php
    //====================================
    // 订单导入提交订单获取任务示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $secret = '';                          // 授权secret
    $param = array (
        'shopType' => '',                  // 店铺类型，TAOBAO：淘宝，JINGDONG：京东，TOUTIAO：抖店，PINDUODUO：拼多多
        'shopId' => '',                    // 店铺ID
        'orderStatus' => '',               // 订单状态，UNPAY：未付款；UNSHIP：待发货（默认值）；SHIPED：等待卖家确认收货；FINISH：交易成功/完成；CLOSE：交易关闭/取消
        'updateAtMin' => '',               // 订单更新的最小时间，格式：yyyy-MM-dd HH:mm:ss
        'updateAtMax' => '',               // 订单更新的最大时间，格式：yyyy-MM-dd HH:mm:ss
        'callbackUrl' => '',               // 回调地址，默认仅支持http
        'salt' => ''                       // 回调参数sign的加密参数，非空时回调才会有sign参数
    );
    
    // 请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $sign = md5($post_data['param'].$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://api.kuaidi100.com/ent/order/task';    // 订单导入提交订单获取任务请求地址
    
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
