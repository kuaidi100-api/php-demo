<?php
    //====================================
    // 电子面单下单接口示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $secret = '';                          // 授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (
        'printType' => 'NON',              // 打印类型，NON:只下单不打印（默认）；IMAGE:生成图片短链；HTML:生成html短链；CLOUD:使用快递100云打印机打印
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
            'mobile' => '',                // 收件人的手机号，手机号和电话号二者其一必填
            'tel' => '',                   // 收件人的电话号，手机号和电话号二者其一必填
            'printAddr' => '',             // 收件人地址
            'company' => ''                // 收件人公司名
        ),
        'sendMan' => array (
            'name' => '',                  // 寄件人姓名
            'mobile' => '',                // 寄件人的手机号，手机号和电话号二者其一必填
            'tel' => '',                   // 寄件人的电话号，手机号和电话号二者其一必填
            'printAddr' => '',             // 寄件人地址
            'company' => ''                // 寄件人公司名
        ),
        'cargo' => '文件',                 // 物品名称
        'count' => '1',                    // 物品总数量
        'weight' => '0.5',                 // 物品总重量KG
        'payType' => 'SHIPPER',            // 支付方式
        'expType' => '标准快递',           // 快递类型: 标准快递（默认）、顺丰特惠、EMS经济
        'remark' => '测试',                // 备注
        'siid' => '',                      // 设备编码
        'direction' => '0',                // 打印方向，0：正方向（默认）； 1：反方向；只有printType为CLOUD时该参数生效
        'tempId' => '',                    // 主单模板：快递公司模板V2链接：https://api.kuaidi100.com/manager/v2/shipping-label/template-shipping-label
        'childTempId' => '',               // 子单模板：快递公司模板V2链接：https://api.kuaidi100.com/manager/v2/shipping-label/template-shipping-label
        'backTempId' => '',                // 回单模板：快递公司模板V2链接：https://api.kuaidi100.com/manager/v2/shipping-label/template-shipping-label
        'valinsPay' => '',                 // 保价额度
        'collection' => '',                // 代收货款额度
        'needChild' => '0',                // 是否需要子单
        'needBack' => '0',                 // 是否需要回单
        'orderId' => null,                 // 贵司内部自定义的订单编号,需要保证唯一性
        'callBackUrl' => null,             // 打印状态回调地址，默认仅支持http
        'salt' => '',                      // 签名用随机字符串
        'needSubscribe' => false,          // 是否开启订阅功能 false：不开启(默认)；true：开启
        'pollCallBackUrl' => null,         // 如果needSubscribe 设置为true时，pollCallBackUrl必须填入，用于跟踪回调
        'resultv2' => '0',                 // 添加此字段表示开通行政区域解析或地图轨迹功能
        'needDesensitization' => false,    // 是否脱敏 false：关闭（默认）；true：开启
        'needLogo' => false,               // 面单是否需要logo false：关闭（默认）；true：开启
        'thirdOrderId' => null,            // 平台导入返回的订单id：如平台类加密订单，使用此下单为必填
        'oaid' => null,                    // 淘宝订单收件人ID (Open Addressee ID)，长度不超过128个字符，淘宝订单加密情况用于解密
        'thirdTemplateURL' => null,        // 第三方平台面单基础模板链接，如为第三方平台导入订单选填，如不填写，默认返回两联面单模板
        'thirdCustomTemplateUrl' => null,  // 第三方平台自定义区域模板地址
        'customParam' => null,             // 面单自定义参数
        'needOcr' => false,                // 第三方平台订单是否需要开启ocr，开启后将会通过推送方式推送 false：关闭（默认）；true：开启
        'ocrInclude' => null,              // orc需要检测识别的面单元素
        'height' => null,                  // 打印纸的高度，以mm为单位
        'width' => null                    // 打印纸的宽度，以mm为单位
    );
    
    //请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://api.kuaidi100.com/label/order?method=order';    // 电子面单下单接口请求地址
    
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
