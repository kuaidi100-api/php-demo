<?php
    //====================================
    // 同城配送下单接口示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/page/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $secret = '';                          // 授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (
        'com' => '',                       // 快递公司，一律用小写字母，见参数字典
        'recManName' => '',                // 收件人姓名
        'recManMobile' => '',              // 收件人的手机号，手机号和电话号二者其一必填
        'recManPrintAddr' => '',           // 收件人所在完整地址，如：广东深圳市深圳市南山区科技南十二路2号金蝶软件园
        'sendManName' => '',               // 寄件人姓名
        'sendManMobile' => '',             // 寄件人的手机号，手机号和电话号二者其一必填
        'sendManPrintAddr' => '',          // 寄件人所在完整地址，如：广东深圳市深圳市南山区科技南十二路2号金蝶软件园B10
        'callbackUrl' => '',               // 订单信息回调，默认仅支持http
        'orderType' => '0',                // 订单类型 0：立即单（默认） 1：预约单
        'pickupTime' => '',                // 预约取件时间（2020-02-02 22:00:00）,预约件必填
        'weight' => '0.5',                 // 物品总重量KG，不需要带单位，例：0.5
        'serviceType' => '',               // 快递业务服务类型，例：文件广告；对照参数字典：https://api.kuaidi100.com/document/606445f6122cae053a5f6f54
        'remark' => '测试',                // 备注
        'salt' => '',                      // 签名用随机字符串
        'orderSourceNo' => '',             // 物品来源单号（比如美团、饿了么订单方便骑手取货）
        'orderSourceType' => '',           // 物品来源（比如美团、饿了么订单方便骑手取货）
        'storeId' => '',                   // 店铺id（对应快递公司提供的店铺标识）
        'additionFee' => '',               // 小费，单位分，不需要带单位，例：1000
        'price' => '',                     // 商品价格，单位分，不需要带单位，例：1000
        'partnerId' => '',                 // 服务商授权信息，对照参数字典
        'partnerKey' => '',                // 服务商授权信息，对照参数字典
        'goods' => array (
            'name' => '',                  // 商品名称
            'price' => '',                 // 商品价格，单位：分
            'count' => '',                 // 商品数量
            'unit' => ''                   // 商品单位
        )
    );
    
    //请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://order.kuaidi100.com/sameCity/order?method=order';    // 同城配送下单接口请求地址
    
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
