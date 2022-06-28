<?php
    //====================================
    // 国际电子面单接口示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $secret = '';                          // 授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (
        'partnerId' => '',                 // 快递公司，月结或支付账号，详见字典表：https://api.kuaidi100.com/document/guojidianzimiandancanshuzidian
        'partnerName' => '',               // 月结账号用户名，详见字典表
        'partnerKey' => '',                // 月结账号密钥，详见字典表
        'partnerSecret' => '',             // 月结账号用户密码，详见字典表
        'code' => '',                      // 账号参数，详见字典表
        'kuaidicom' => '',                 // 快递公司的编码，一律用小写字母，详见字典表：https://api.kuaidi100.com/document/guojidianzimiandancanshuzidian
        'recMan' => array (
            'name' => '',                  // 收件人姓名
            'mobile' => '',                // 收件人的手机号，手机号和电话号二者其一必填
            'addr' => '',                  // 收件人所在完整地址
            'district' => '',              // 郡|县,可作为收件地址补充
            'province' => '',              // 州|省,可作为收件地址补充
            'company' => '',               // 公司名称
            'countryCode' => '',           // 国家代号 CN-中国 ,US-美国等, 详见字典表：https://api.kuaidi100.com/document/guojidianzimiandancanshuzidian
            'city' => '',                  // 城市
            'stateOrProvinceCode' => '',   // 州代号:例如美国纽约州-NY
            'zipcode' => '',               // 邮编
            'tel' => '',                   // 电话
            'email' => '',                 // 邮箱
            'taxId' => '',                 // 税号
            'taxType' => '',               // 纳税人类型
            'vatNum' => '',                // VAT税号(数字或字母)；欧盟国家(含英国)使用的增值税号
            'eoriNum' => '',               // EORI号码(数字或字母)；欧盟入关时需要EORI号码，用于商品货物的清关
            'iossNum' => ''                // IOSS号码
        ),
        'sendMan' => array (
            'name' => '',                  // 寄件人姓名
            'mobile' => '',                // 寄件人的手机号
            'addr' => '',                  // 寄件人所在的完整地址
            'district' => '',              // 郡|县,可作为寄件地址补充
            'province' => '',              // 州|省,可作为寄件地址补充
            'company' => '',               // 公司名称
            'countryCode' => '',           // 国家代号 CN-中国 ,US-美国等, 详见字典表：https://api.kuaidi100.com/document/guojidianzimiandancanshuzidian
            'city' => '',                  // 城市
            'stateOrProvinceCode' => '',   // 州代号:例如美国纽约州-NY
            'zipcode' => '',               // 邮编
            'tel' => '',                   // 电话
            'email' => '',                 // 邮箱
            'taxId' => '',                 // 税号
            'taxType' => '',               // 纳税人类型
            'vatNum' => '',                // VAT税号(数字或字母)；欧盟国家(含英国)使用的增值税号
            'eoriNum' => '',               // EORI号码(数字或字母)；欧盟入关时需要EORI号码，用于商品货物的清关
            'iossNum' => ''                // IOSS号码
        ),
        'cargo' => '',                     // 货物描述
        'weight' => '',                    // 物品总重量
        'expType' => '标准快递',            // 产品类型： 默认标准快递, 详见字典表：https://api.kuaidi100.com/document/guojidianzimiandancanshuzidian
        'remark' => '测试',                // 备注
        'customsValue' => '',              // 申报价值,包裹类必填,货币单位根据currency确定,人民币单位是元
        'unitOfMeasurement' => 'SI',       // SI:千克和厘米组合；SU:磅和英寸组合，默认是SI
        'tradeTerm' => '',                 // 贸易条款;CFR,DAP等,国际贸易规范用于,默认DAP
        'currency' => '',                  // 货币单位,CNY-人民币;USD-美元;默认CNY
        'packageInfos' => array (          // 包裹信息集合，jsonArray数组列表
            array (
                'height' => '',            // 高度;单位厘米,默认1.0
                'width' => '',             // 宽度;单位厘米, 默认10.0
                'length' => '',            // 长度;单位厘米默认10.0
                'weight' => '',            // 重量; 单位千克,默认0.1
                'packageReference' => ''   // 该包裹的备注信息之类
            )
        ),
        'exportInfos' => array (           // 出口信息集合,一般包裹类要求必填,文件类不用填,用于清关报备，jsonArray数组列表
            array (
                'netWeight' => '',                   // 净重,单位kg,默认0.1
                'grossWeight' => '',                 // 毛重,单位kg,默认 0.1
                'manufacturingCountryCode' => '',    // 生产国代号;CN-中国,US-美国
                'unitPrice' => '',                   // 物品单价,货币单位根据currency确定,人民币单位是元
                'quantity' => '',                    // 物品数量,整数,默认1
                'quantityUnitOfMeasurement' => '',   // 计数单位,必填;PCS-件,KG-千克等,默认PCS
                'desc' => '',                        // 物品描述
                'exportCommodityCode' => '',         // 出口商品码,建议填写,加快清关速度
                'importCommodityCode' => ''          // 进口商品码,建议填写,加快清关速度
            )
        ),
        'dutiesPaymentType' => array (      // 关税支付方式,默认收件人支付
            'paymentType' => 'DDP',         // 支付方式:DDU-寄方支付;DDP-收方支付;默认DDP
            'account' => ''                 // 账号
        ),
        'freightPaymentType' => array (     // 运费支付方式
            'paymentType' => 'SHIPPER',     // 支付方式:SHIPPER-寄方付;CONSIGNEE-收方付 默认SHIPPER
            'account' => ''                 // 账号
        ),
        'customsClearance' => array (       // 清关信息
            'purpose' => '',                // 出口目的
            'document' => true              // 是否是文件,默认true,是文件
        ),
        'invoiceInfo' => array (            // 发票信息
            'date' => '',                   // 发票日期（格式：yyyy-MM-dd）
            'number' => '',                 // 发票号
            'type' => '',                   // 发票类型,默认是商业发票,默认商业类型发票
            'title' => '',                  // 发票抬头,base64字符或常规字符,不同快递公司要求不一样
            'signature' => '',              // 发票签名（BASE64字符串）
            'pltEnable' => false            // 是否启用无纸化贸易(部分快递公司支持),true-启用,false-不启用
        ),
        'routeId' => '',                    // 路线ID(极兔国际必填)
        'needInvoice' => false              // 是否需要发票,默认false
    );
    
    //请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://order.kuaidi100.com/sameCity/order?method=order';    // 国际电子面单接口请求地址
    
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
