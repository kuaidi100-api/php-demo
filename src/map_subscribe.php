<?php
    //====================================
    // 地图轨迹订阅示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/page/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                            // 客户授权key
    $param = array (
        'key' => $key,                    // 客户授权key
        'company' => 'yunda',             // 快递公司编码
        'number' => '3950055201640',      // 快递单号
        'from' => '',                     // 出发地城市
        'to' => '',                       // 目的地城市
        'parameters' => array (
            'callbackurl' => '',          // 回调地址
            'salt' => '',                 // 加密串
            'phone' => '',                // 手机号
            'ordertime' => '',            // 订单下单时间，格式“yyyy-MM-dd HH”
            'resultv2' => '5'             // 添加此字段表示开通行政区域解析功能
        )
    );
    
    // 请求参数
    $post_data = array();
    $post_data['schema'] = 'json';
    $post_data['param'] = json_encode($param);
    
    $url = 'http://poll.kuaidi100.com/pollmap';             // 地图轨迹订阅请求地址
    
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
