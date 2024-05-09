<?php
    //====================================
    // 订单拦截示例代码（php）
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $secret = '';                          // 授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (                          //此处参数值为示例，请自行替换填充
            'callbackUrl'=>'http=>//api.kuaidi100.com/test/callback',
            'interceptPayType'=>'THIRDPARTY',
            'interceptType'=>'MODIFY_ADDR',
            'kuaidicom'=>'jtexpress',
            'kuaidinum'=>'JT12345678',
            'orderId'=>'123456789',
            'orderRole'=>'1',
            'partnerId'=>'12345678',
            'partnerKey'=>'12345678',
            'reason'=>'测试拦截',
            'recManInfo'=> array(
                'mobile'=>'130******66',
                'name'=>'张三',
                'printAddr'=>'广东省深圳市南山区粤海街道科技南十二路金蝶软件园'
            ),
            'salt'=>'kuaidi1000api@salt'
            
    );
    
    //请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://api.kuaidi100.com/label/order?method=interceptOrder';    // 订单拦截接口请求地址
    
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
