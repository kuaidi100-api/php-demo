<?php
    //====================================
    // 电子面单返回图片示例代码
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
        'recManName' => '',                // 收件人姓名
        'recManMobile' => '',              // 收件人手机
        'recManPrintAddr' => '',           // 收件人地址
        'sendManName' => '',               // 寄件人姓名
        'sendManMobile' => '',             // 寄件人手机
        'sendManPrintAddr' => '',          // 寄件人地址
        'tempid' => '',                    // 电子面单模板编码
        'thirdTemplateURL' => '',          // 第三方平台面单基础模板链接
        'cargo' => '文件',                 // 物品名称
        'thirdOrderId' => '',              // 平台导入返回的订单id
        'oaid' => '',                      // 淘宝订单收件人ID (Open Addressee ID)，长度不超过128个字符
        'count' => '1',                    // 物品总数量
        'weight' => '0.5',                 // 物品总重量
        'payType' => 'SHIPPER',            // 支付方式
        'expType' => '标准快递',            // 快递类型: 标准快递（默认）、顺丰特惠、EMS经济
        'remark' => '测试',                 // 备注
        'valinsPay' => '',                 // 保价额度
        'collection' => '',                // 代收货款额度
        'needChild' => '0',                // 是否需要子单
        'needBack' => '0',                 // 是否需要回单
        'orderId' => null,                 // 贵司内部自定义的订单编号,需要保证唯一性
        'height' => null,                  // 打印纸的高度
        'width' => null,                   // 打印纸的宽度
        'salt' => '',                      // 签名用随机字符串
        'op' => '0',                       // 是否开启订阅功能 0：不开启(默认) 1：开启
        'pollCallBackUrl' => null,         // 如果op设置为1时，pollCallBackUrl必须填入，用于跟踪回调
        'resultv2' => '0',                 // 添加此字段表示开通行政区域解析或地图轨迹功能
        'asyn' => '0',                     // 是否开启异步对推送图片
        'callBackUrl' => ''                // 开启异步推送时，需要提交的接收图片内容接口
    );
    
    // 请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'http://poll.kuaidi100.com/printapi/printtask.do?method=getPrintImg';    // 电子面单请求地址
    
echo '请求参数：<br/><pre>';
echo print_r($post_data);
echo '</pre>';
    
    // 发送post请求
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
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
