<?php
    //====================================
    // 电子面单返回图片示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/page/myinfo/enterprise
    //====================================

    //参数设置
    $key = '';                        //客户授权key
    $secret = '';                     //授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    //当前时间戳
    $param = array (
        'type' => '10',                    //业务类型，默认为10
        'partnerId' => '',                 //电子面单客户账户或月结账号
        'partnerKey' => '',                //电子面单密码
        'net' => '',                       //收件网点名称,由快递公司当地网点分配
        'kuaidicom' => '',                 //快递公司的编码
        'recManName' => '',                //收件人姓名
        'recManMobile' => '',              //收件人手机
        'recManPrintAddr' => '',           //收件人地址
        'sendManName' => '',               //寄件人姓名
        'sendManMobile' => '',             //寄件人手机
        'sendManPrintAddr' => '',          //寄件人地址
        'tempid' => '',                    //电子面单模板编码
        'cargo' => '',                     //物品名称
        'count' => '',                     //物品总数量
        'weight' => '',                    //物品总重量
        'payType' => 'SHIPPER',            //支付方式
        'expType' => '标准快递',           //快递类型: 标准快递（默认）、顺丰特惠、EMS经济
        'remark' => ''                     //备注
    );
    
    //请求参数
    $post_data = array();
    $post_data["param"] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data["key"] = $key;
    $post_data["t"] = $t;
    $sign = md5($post_data["param"].$t.$key.$secret);
    $post_data["sign"] = strtoupper($sign);
    
    $url = 'http://poll.kuaidi100.com/printapi/printtask.do?method=getPrintImg';    //电子面单请求地址
    
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
