<?php
    //====================================
    // 云打印自定义生成图片接口示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                           // 客户授权key
    $secret = '';                        // 授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (
        'type' => '30',                  // 业务类型，值为：30
        'orderId' => null,               // 贵司内部自定义的订单编号,需要保证唯一性
        'tempid' => '',                  // 电子面单模板编码，通过后台模板管理页面获取：https://api.kuaidi100.com/manager/page/template/eletemplate
        'height' => '100',               // 打印纸的高度，以mm为单位，例如：100
        'width' => '75',                 // 打印纸的宽度，以mm为单位，例如：75
    );
    
    //请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://poll.kuaidi100.com/printapi/printtask.do?method=getPrintImg';    // 自定义生成图片接口请求地址
    
echo '<br/>请求参数：<br/><pre>';
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

    // 这里需要注意：如果使用 json_decode 进行字符串转换为json对象时，如果第二个参数为 true，那么这里可以使用数组方式访问；否则就要换成 -> 箭头方式访问属性
    $images = json_decode($data['data']['imgBase64'], true);
    echo "<br/><br/>图片信息：<br/><br/><img style='width: 400px;margin-left:2em;' src='data:image/png;base64,$images[0]'/><br/>";
?>
