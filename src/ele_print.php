<?php
    //====================================
    // 电子面单打印示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/page/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $secret = '';                          // 授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (
        'type' => '10',                    // 业务类型，默认为10
        'partnerId' => '',                 // 电子面单客户账户或月结账号
        'partnerKey' => '',                // 电子面单密码
        'partnerSecret' => '',             // 电子面单密钥
        'partnerName' => '',               // 电子面单客户账户名称
        'net' => '',                       // 收件网点名称,由快递公司当地网点分配
        'code' => '',                      // 电子面单承载编号
        'checkMan' => '',                  // 电子面单承载快递员名
        'tbNet' => '',                     // 在使用菜鸟/淘宝/拼多多授权电子面单时，若月结账号下存在多个网点，则tbNet="网点名称,网点编号" ，注意此处为英文逗号
        'kuaidicom' => '',                 // 快递公司的编码：https://api.kuaidi100.com/document/5f0ff6e82977d50a94e10237.html
        'recMan' => array (
            'name' => '',                  // 收件人姓名
            'mobile' => '',                // 收件人手机
            'printAddr' => '',             // 收件人地址
            'company' => ''                // 收件人公司名
        ),
        'sendMan' => array (
            'name' => '',                  // 寄件人姓名
            'mobile' => '',                // 寄件人手机
            'printAddr' => '',             // 寄件人地址
            'company' => ''                // 寄件人公司名
        ),
        'cargo' => '文件',                 // 物品名称
        'count' => '1',                    // 物品总数量
        'weight' => '0.5',                 // 物品总重量KG
        'payType' => 'SHIPPER',            // 支付方式
        'expType' => '标准快递',            // 快递类型: 标准快递（默认）、顺丰特惠、EMS经济
        'remark' => '测试',                // 备注
        'tempid' => '',                    // 电子面单模板编码，通过后台模板管理页面获取：https://api.kuaidi100.com/manager/page/template/eletemplate
        'thirdTemplateURL' => '',          // 第三方平台面单基础模板链接
        'siid' => '',                      // 设备编码
        'valinsPay' => '',                 // 保价额度
        'collection' => '',                // 代收货款额度
        'needChild' => '0',                // 是否需要子单
        'needBack' => '0',                 // 是否需要回单
        'orderId' => null,                 // 贵司内部自定义的订单编号,需要保证唯一性
        'callBackUrl' => null,             // 打印状态回调地址，默认仅支持http
        'salt' => '',                      // 签名用随机字符串
        'op' => '0',                       // 是否开启订阅功能 0：不开启(默认) 1：开启
        'pollCallBackUrl' => null,         // 如果op设置为1时，pollCallBackUrl必须填入，用于跟踪回调
        'resultv2' => '0'                  // 添加此字段表示开通行政区域解析或地图轨迹功能
    );
    
    //请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://poll.kuaidi100.com/printapi/printtask.do?method=eOrder';    // 电子面单打印请求地址
    
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
