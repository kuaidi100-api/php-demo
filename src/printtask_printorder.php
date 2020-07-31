<?php
    //====================================
    // 云打印-自定义内容示例代码
    //====================================

    //参数设置
    $param = array (
        'orderId' => '',            //贵司内部自定义的订单编号,需要保证唯一性
        'tempid' => '',             //通过管理后台的打印摸版配置信息获取
        'siid' => '',               //打印设备编码
        'height' => '',             //打印纸的高度
        'width' => '',              //打印纸的宽度
        'callBackUrl' => '',        //打印状态回调地址
        'salt' => '',               //签名用随机字符串
    );
    
    $param_str = json_encode($param);
    $key = '';                //客户授权key
    $secret = '';             //客户电子面单secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    //当前请求时间戳
    $sign = strtoupper(md5($param_str.$t.$key.$secret));

    //请求参数
    $post_data = array();
    $post_data["key"] = $key;
    $post_data["sign"] = $sign;
    $post_data["t"] = $t;
    $post_data["param"] = $param;
    
    $url = 'http://poll.kuaidi100.com/printapi/printtask.do?method=printOrder';    //获取电子面单
    
    $params = "";
    foreach ($post_data as $k=>$v) {
        $params .= "$k=".urlencode($v)."&";        //默认UTF-8编码格式
    }
    $post_data = substr($params, 0, -1);
echo '请求参数<br/>'.$post_data;
    
    //发送post请求
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($ch);
    $data = str_replace("\"", '"', $result );
    $data = json_decode($data);

echo '<br/><br/>返回数据<br/>';
echo var_dump($data);

?>