<?php
    //====================================
    // 快递预估时效查询示例代码（php）
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $secret = '';                          // 授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (                                     //此处参数值为示例，请自行替换填充
        'kuaidicom' => 'jd',                             //快递公司编码
        'from' => '广东广州市白云区',                     //出发地（地址需包含3级及以上），例如：广东深圳南山区
        'to' => '广东深圳市南山区',                       //目的地（地址需包含3级及以上），例如：北京海淀区
        'orderTime' => '2023-10-12 08:00:00',            //下单时间，格式要求yyyy-MM-dd HH:mm:ss, 例如：2023-08-08 08:08:08
        'expType' => '特惠送'                            //产品类型
    );
    
    //请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://api.kuaidi100.com/label/order?method=time';    // 快递预估时效查询接口请求地址
    
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
