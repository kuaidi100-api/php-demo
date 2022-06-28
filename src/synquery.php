<?php
    //====================================
    // 实时查询示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================

    //参数设置
    $key = '';                        // 客户授权key
    $customer = '';                   // 查询公司编号
    $param = array (
        'com' => 'yunda',             // 快递公司编码
        'num' => '3950055201640',     // 快递单号
        'phone' => '',                // 手机号
        'from' => '',                 // 出发地城市
        'to' => '',                   // 目的地城市
        'resultv2' => '1',            // 开启行政区域解析
        'show' => '0',                // 返回格式：0：json格式（默认），1：xml，2：html，3：text
        'order' => 'desc'             // 返回结果排序:desc降序（默认）,asc 升序
    );
    
    //请求参数
    $post_data = array();
    $post_data['customer'] = $customer;
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $sign = md5($post_data['param'].$key.$post_data['customer']);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://poll.kuaidi100.com/poll/query.do';    // 实时查询请求地址
    
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
    // 第二个参数为true，表示格式化输出json
    $data = json_decode($result, true);

echo '<br/><br/>返回数据：<br/><pre>';
echo print_r($data);
//echo var_dump($data);
echo '</pre>';
?>
