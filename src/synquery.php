<?php
    //====================================
    // 实时查询示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/page/myinfo/enterprise
    //====================================

    //参数设置
    $key = '';                        //客户授权key
    $customer = '';                   //查询公司编号
    $param = array (
        'com' => 'yunda',             //快递公司编码
        'num' => '3950055201640',     //快递单号
        'phone' => '',                //手机号
        'from' => '',                 //出发地城市
        'to' => '',                   //目的地城市
        'resultv2' => '1'             //开启行政区域解析
    );
    
    //请求参数
    $post_data = array();
    $post_data["customer"] = $customer;
    $post_data["param"] = json_encode($param);
    $sign = md5($post_data["param"].$key.$post_data["customer"]);
    $post_data["sign"] = strtoupper($sign);
    
    $url = 'http://poll.kuaidi100.com/poll/query.do';    //实时查询请求地址
    
    $params = "";
    foreach ($post_data as $k=>$v) {
        $params .= "$k=".urlencode($v)."&";              //默认UTF-8编码格式
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
