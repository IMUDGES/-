<?php session_start(); ?>
<?php
/**
 * 发起http post请求(REST API), 并获取REST请求的结果
 * @param string $url
 * @param string $param
 * @return - http response body if succeeds, else false.
 */
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

$token = $_SESSION['token'];
$url = 'https://aip.baidubce.com/rest/2.0/face/v2/faceset/group/getusers?access_token=' . $token;
$bodys = array(
    "group_id" => "1",
    "start" => "0",
    "num" => "100"
);
$res = request_post($url, $bodys);

$obj = json_decode($res);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>查询结果</title>
</head>
<body>
	<table>
    	<th>uid</th>
        <th>姓名</th>
        <?php 
			$user=$obj->{'result'};
			$n=count($user);
			for($i=0;$i<$n;$i++)
			{?>
				<tr>
                	<td><?php echo $user[$i]->uid; ?></td>
                    <td><?php echo $user[$i]->user_info; ?></td>
                </tr>
		<?php }
		?>
    </table>
</body>
</html>