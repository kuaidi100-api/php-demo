<?php
    //====================================
    // 智能判断示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================
    
    // 参数设置
    $key = '';                        // 客户授权key
    $num = '3950055201640';           // 单号
    // 请求参数
    $post_data = array();
    $post_data["key"] = $key;
    $post_data["num"] = $num;
    
    $url = 'http://www.kuaidi100.com/autonumber/auto';    // 智能判断请求地址
    
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
