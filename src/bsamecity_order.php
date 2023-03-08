<?php
    //====================================
    // 同城寄件下单接口
    //====================================
    
    // 参数设置
    $key = '';                         // 客户授权key
    $secret = '';                      // 客户授权secret
    list($msec, $sec) = explode(' ', microtime());
    $t = (float)sprintf('%.0f', (floatval($msec) + floatval($sec)) * 1000);    // 当前时间戳
    $param = array (
        'kuaidicom'=>'shunfengtongcheng',  //快递公司的编码，一律用小写字母，见《快递公司编码》
        'lbsType'=>'2',                    //坐标类型(1：百度坐标，2：高德坐标 ,默认2) 
        'recManName'=>'顺丰同城',           //收件人姓名，长度最大20
        'recManMobile'=>'13012345678',     //收件人的手机号（有手机号和固话正则校验）
        'recManProvince'=>'北京市',         //收件人所在的省，长度最大20
        'recManCity'=>'北京市',             //收件人所在的市，长度最大20
        'recManDistrict'=>'海淀区',         //收件人所在的区，长度最大20
        'recManAddr'=>'学清嘉创大厦A座15层', //收件人所在的完整地址，如 科技南十二路2号金蝶软件园B10，长度最大100
        'recManLat'=>'40.014838',           //收件人地址纬度，默认高德坐标，长度最大10
        'recManLng'=>'116.352569',          //收件人地址经度，默认高德坐标，长度最大10
        'sendManName'=>'测试',               //寄件人姓名，长度最大20
        'sendManMobile'=>'13012345679',     //寄件人的手机号（有手机号和固话正则校验）
        'sendManProvince'=>'北京',           //寄件人所在的省，长度最大20
        'sendManCity'=>'北京市',             //寄件人所在的市，长度最大20
        'sendManDistrict'=>'海淀区',         //寄件人所在的区，长度最大20
        'sendManAddr'=>'清华大学',           //寄件人所在的完整地址，如 科技南十二路2号金蝶软件园B10，长度最大100
        'sendManLat'=>'40.002436',          //寄件人地址纬度，默认高德坐标，长度最大10
        'sendManLng'=>'116.326582',         //寄件人地址经度，默认高德坐标，长度最大10
        'weight'=>'1',                      //物品总重量KG，例：1.5，单位kg
        'remark'=>'测试下单',                //备注,例：测试寄件，长度最多255
        'volume'=>'',                       //体积cm3，长度最多20
        'orderType'=>'0',                   //0：无需预约 1：预约单送达时间 2：预约单上门时间 默认为0
        'expectPickupTime'=>'',             //取货时间，orderType=2时必填，例子：2020-02-02 22:00
        'expectFinishTime'=>'',             //期望送达时间，orderType=1时必填（例子：2020-02-02 22:00）
        'insurance'=>'',                    //保价物品金额
        'price'=>'0',                        //物品总金额，例：100.23
        'directDelivery'=>'0',
        'callbackUrl'=>'http://www.baidu.com',//下单信息回调接口
        'salt'=>'',                          //签名用随机字符串
        'goods'=>array(                      //物品明细
            array(
                'name'=>'外卖',
                'type'=>'食品',
                'count'=>0
            )
        )
    );
    
    // 请求参数
    $post_data = array();
    $post_data['param'] = json_encode($param, JSON_UNESCAPED_UNICODE);
    $post_data['key'] = $key;
    $post_data['t'] = $t;
    $sign = md5($post_data['param'].$t.$key.$secret);
    $post_data['sign'] = strtoupper($sign);

    $url = 'https://api.kuaidi100.com/bsamecity/order?method=order';    // 同城寄件下单接口地址
    
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