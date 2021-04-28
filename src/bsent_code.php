<?php
    //====================================
    // 商家寄件获取取件码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/page/myinfo/enterprise
    //====================================
	
    //参数设置
    $key = '';            //客户授权key
    $secret = '';         //客户授权secret
	$param = array (
        'taskId' => '',            //任务ID
        'orderId' => ''            //订单ID
    );
    $param_str = json_encode($param, JSON_UNESCAPED_UNICODE);
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    //当前时间戳
    $sign = strtoupper(md5($param_str.$t.$key.$secret));

    //请求参数
    $post_data = array();
    $post_data["method"] = 'getCode';
    $post_data["key"] = $key;
    $post_data["t"] = $t;
    $post_data["sign"] = $sign;
    $post_data["param"] = $param_str;

    $url = 'http://order.kuaidi100.com/order/borderbestapi.do';    //商家寄件
    
    echo '<br/>请求参数<br/>';
    foreach ($post_data as $k=>$v) {
        echo "<br/>$k=".$v;
    }
    
    //发送post请求
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    $data = json_decode($result);

echo '<br/><br/>返回数据<br/>';
echo var_dump($data);
?>