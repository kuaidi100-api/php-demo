<?php
    //====================================
    // 电子面单OCR识别示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================

    // 参数设置
    $key = '';                             // 客户授权key
    $param = array (
        'image' => '',                     // 图像数据，base64编码，要求base64编码后大小不超过4M,支持jpg/jpeg/png/bmp格式
        'enableTilt' => false,             // 是否兼容图像倾斜，true：是；false：否，默认不检测，即：false
        'include' => null,                 // 需要检测识别的面单元素。取值范围：barcode,qrcode,receiver,sender,bulkpen
        'imageUrl' => null,                // 图片URL。image、imageUrl、pdfUrl三者必填其一，优先顺序：image>imageUrl>pdfUrl
        'pdfUrl' => null,                  // PDF文件URL。image、imageUrl、pdfUrl三者必填其一，优先顺序：image>imageUrl>pdfUrl
    );
    
    //请求参数
    $post_data = array();
    $post_data['key'] = $key;
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    
    $url = 'http://api.kuaidi100.com/elec/detocr';    // 电子面单打印请求地址
    
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
