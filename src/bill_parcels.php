<?php
    //====================================
    // 快递发货单打印接口示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $secret = '';                          // 授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (
        'tempid' => '',                    // 模板编码，通过管理后台获取：https://api.kuaidi100.com/manager/page/template/fhtemplate
        'siid' => '',                      // 打印设备编码，通过打印机输出的设备码进行获取
        'callBackUrl' => '',               // 打印状态回调地址，默认仅支持http
        'total' => '23',
        'discPrice' => '22',
        'payPrice' => '18',
        'tab0' => array (                  // 发货单表格列表内容，JsonArrayString类型，多表格时用tab0，tab1，tab2等追加对象
            array (
                'prodName' => '商品名1',
                'count' => '数量1',
                'unitPrice' => '单价1',
                'totalPrice' => '总金额1'
            ),
            array (
                'prodName' => '商品名2',
                'count' => '数量2',
                'unitPrice' => '单价2',
                'totalPrice' => '总金额2'
            ),
        ),
        'img0' => array (                  // 多图片时用img0,img1,img2等追加
            'type' => 'URL',               // BASE_64：base64 图片格式；URL：图片地址；QR_CODE：二维码；CODE_128：code128格式的条形码
            'content' => 'https://cdn.kuaidi100.com/images/openApiWeb/common/logo.png',    // 图片内容
            'width' => '80',               // 图片宽度
            'height' => '100'              // 图片高度
        )
    );
    $settings = array (
        'pageWidth' => '100',              // 宽，单位mm，默认值：100
        'pageHeight' => null,              // 高，单位mm ，续打纸张时，该字段设置为null或空串
        'margins' => array (
            'top' => null,                 // 上边距，单位：mm，默认：0
            'bottom' => null,              // 下边距，单位：mm，默认：0
            'left' => null,                // 左边距，单位：mm，默认：0
            'right' => null                // 右边距，单位：mm，默认：0
        )
    );
    
    //请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['settings'] = json_encode($settings, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);
    
    $url = 'https://poll.kuaidi100.com/print/billparcels.do?method=billparcels';    // 快递发货单打印接口请求地址
    
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
