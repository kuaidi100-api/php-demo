<?php
    //====================================
    // 智能判断示例代码
    //====================================
    //参数设置
    $key = '';                        //客户授权key
    $num = '3950055201640';           //单号
    //请求参数
    $post_data = array();
    $post_data["key"] = $key;
    $post_data["num"] = $num;
    
    $url = 'http://www.kuaidi100.com/autonumber/auto';    //智能判断请求地址
    
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
