<?php
function request_post($url = '', $param = '')
{
    if (empty($url) || empty($param)) {
        return false;
    }

    $postUrl = $url;
    $curlPost = $param;
    // 初始化curl
    $curl = curl_init();
    curl_setopt($curl, CURLOPT_URL, $postUrl);
    curl_setopt($curl, CURLOPT_HEADER, 0);
    // 要求结果为字符串且输出到屏幕上
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
    // post提交方式
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_setopt($curl, CURLOPT_POSTFIELDS, $curlPost);
    // 运行curl
    $data = curl_exec($curl);
    curl_close($curl);

    return $data;
}
function access_token($ak, $sk)
{
	$url = 'https://aip.baidubce.com/oauth/2.0/token';
    $post_data = array();
    $post_data['grant_type']  = 'client_credentials';
    $post_data['client_id']   = $ak;
    $post_data['client_secret'] = $sk;
    $res = request_post($url, $post_data);
    if (!!$res) {
        $res = json_decode($res, true);
        return $res['access_token'];
    } else {
        return false;
    }
}
$apk='nFNxsn45GRCZDe7eHf0DdGBs';
$spk='mAGjH6FOFqXSC3Rxyqf4CG7ffGc3RPPR';
$token = access_token($apk, $spk);?>
<?php session_start(); ?>
<?php $_SESSION['token']=$token; ?>
