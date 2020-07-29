<?php
    //====================================
    // 短信请求示例代码
    //====================================

    //参数设置
    $key = '';            //客户授权key
    $userid = '';         //短信接口用户ID
    $seller = '';         //商户名称签名
    $phone = '';          //接收短信手机号
    $tid = 0;             //短信模板ID
    $content = array (
        '验证码' => '256988',
        'remark' => '（若非本人操作请忽略）'
    );                     //短信模板替换内容
    $outorder = '';        //外部订单号
	$callback = '';        //短信状态回调地址
    
    $sign = strtoupper(md5($key.$userid));

    //请求参数
    $post_data = array();
    $post_data["sign"] = $sign;
    $post_data["userid"] = $userid;
    $post_data["seller"] = $seller;
    $post_data["phone"] = $phone;
    $post_data["tid"] = $tid;
    $post_data["content"] = json_encode($content);
    $post_data["outorder"] = $outorder;
    $post_data["callback"] = $callback;

    $url = 'http://apisms.kuaidi100.com:9502/sms/send.do';    //获取电子面单
    
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