<?php
    //====================================
    // 云打印附件打印接口示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/page/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $secret = '';                          // 授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (
        'orderId' => null,                 // 贵司内部自定义的订单编号,需要保证唯一性
        'height' => null,                  // 打印纸的高度，以mm为单位，例如：100
        'width' => null,                   // 打印纸的宽度，以mm为单位，例如：75
        'copyNum' => null,                 // 需要打印的份数，默认是一份
        'startPage' => null,               // 打印范围，起始页，仅对多页文件支持，默认是打印整个文档
        'endPage' => null,                 // 打印范围，结束页，仅对多页文件支持，默认是打印整个文档
        'salt' => '',                      // 签名用随机字符串
        'siid' => '',                      // 打印设备编码，通过打印机输出的设备码进行获取
        'callBackUrl' => null              // 打印状态回调地址，默认仅支持http
    );
    
    //请求参数
    $param = json_encode($param, JSON_UNESCAPED_UNICODE);
    $sign = md5($param.$t.$key.$secret);
    $sign = strtoupper($sign);
    $param = urlencode($param);
    $file = 'F:\\netstat.png';    // 需要打印的附件路径
    $file_data = array (
        'file' => curl_file_create($file, 'image/png', 'netstat.png')   // 创建curl文件对象：文件路径，文件类型，文件名
    );

    $url = "https://poll.kuaidi100.com/printapi/printtask.do?method=imgOrder&key=$key&t=$t&param=$param&sign=$sign";    // 附件打印接口请求地址
    
echo '请求参数：<br/><pre>';
echo print_r($url);
echo '</pre>';
    
    //发送post请求
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $file_data);
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
