<?php
    //====================================
    // 打印接口回调接收数据示例代码
    // 授权信息可通过链接查看：https://api.kuaidi100.com/manager/v2/myinfo/enterprise
    //====================================

echo '接收数据：<br/>';
    foreach ($_POST as $k=>$v) {
echo "$k=$v".'<br/>';
    }
?>
