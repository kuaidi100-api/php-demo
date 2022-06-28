<?php
    //====================================
    // 自定义打印接口示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $secret = '';                          // 授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (
        'tempid' => '',                    // 电子面单模板编码，通过后台模板管理页面获取：https://api.kuaidi100.com/manager/page/template/eletemplate
        'printType' => '',                 // 打印类型（IMAGE,CLOUD,HTML）。IMAGE:生成图片短链；HTML:生成html短链；CLOUD:使用快递100云打印机打印
        'siid' => '',                      // 设备编码
        'direction' => '0',                // 打印方向，0：正方向（默认）； 1：反方向；只有printType为CLOUD时该参数生效
        'callBackUrl' => '',               // 打印状态回调地址，默认仅支持http
        'customParam' => null              // 面单自定义参数
    );
    
    //请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://api.kuaidi100.com/label/order?method=custom';    // 自定义打印接口请求地址
    
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
