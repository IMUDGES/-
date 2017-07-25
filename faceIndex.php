
<?php session_start(); ?>
<?php
//文件上传
	if ($_FILES["file"]["error"] > 0)
	  {
	  echo "Error: " . $_FILES["file"]["error"] . "<br />";
	  }
	else
	  {
		  /*
	  echo "Upload: " . $_FILES["file"]["name"] . "<br />";
	  echo "Type: " . $_FILES["file"]["type"] . "<br />";
	  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
	  echo "Stored in: " . $_FILES["file"]["tmp_name"];
	  */
	  }
//上传限制
if ((($_FILES["file"]["type"] == "image/jpg")|| ($_FILES["file"]["type"] == "image/jpeg")||
   ($_FILES["file"]["type"] == "image/pjpeg"))&& ($_FILES["file"]["size"] < 20000000))
{
 	 if ($_FILES["file"]["error"] > 0)
  	  {
  		  echo "Error: " . $_FILES["file"]["error"] . "<br />";
  	  }
 	 else
	   {
		 /* echo "Upload: " . $_FILES["file"]["name"] . "<br />";
		  echo "Type: " . $_FILES["file"]["type"] . "<br />";
		  echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
		  echo "Stored in: " . $_FILES["file"]["tmp_name"];
		  */
		//   echo '图片一上传成功';
        }
}
else
{
  echo '图片一上传失败';
}
//保存文件
if ((($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 20000000))
  {
  if ($_FILES["file"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
    }
  else
    {
   /* echo "Upload: " . $_FILES["file"]["name"] . "<br />";
    echo "Type: " . $_FILES["file"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file"]["size"] / 1024) . " Kb<br />";
    echo "Temp file: " . $_FILES["file"]["tmp_name"] . "<br />";
*/
    if (file_exists("upload/" . $_FILES["file"]["name"]))
      {
     // echo $_FILES["file"]["name"] . " already exists. ";
		// echo '图片一已经存在';
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
     // echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
	// echo '图片一保存成功';
      }
    }
  }
else
  {
   		echo '图片一保存失败';
  }
	//保存路径
	$jpg1= "upload/" . $_FILES["file"]["name"];
?>

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
$token=$_SESSION['token'];
$url = 'https://aip.baidubce.com/rest/2.0/face/v2/identify?access_token=' . $token;
$img = file_get_contents($jpg1);
$img = base64_encode($img);
$bodys = array(
    "images" => $img,
    "group_id" => "1"
);
$res = request_post($url, $bodys);
$obj = json_decode($res);
$log_id=strval($obj->{'log_id'});
$uid=$obj->{'result'}[0]->uid;
$score=$obj->{'result'}[0]->scores[0];
$username=$obj->{'result'}[0]->user_info;
mysql_connect("localhost","liqinggang","123456");  
mysql_select_db("test");  
mysql_query("set names 'utf8'");  
$sql = "select username,img from faceuser where uid=$uid";
$result = mysql_query($sql);
$row = mysql_fetch_array($result);  //将数据以索引方式储存在数组中
$img1=$row['img'];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>识别结果</title>
<style>
	img{
			width:300px;
			height:400px;
		}
</style>
</head>
	<p>姓名：<?php echo $username; ?></p>
	<p>相似度：<?php echo $score; ?>%</p>
	<img src="<?php echo $img1?>" title="原图" />
	<img src="<?php echo $jpg1?>" title="新图" />
<body>
</body>
</html>
