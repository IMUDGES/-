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
		   echo '图片一上传成功';
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
		 echo '图片一已经存在';
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
     // echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
	 echo '图片一保存成功';
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
$name=$_POST["name"];
$url = 'https://aip.baidubce.com/rest/2.0/face/v2/faceset/user/add?access_token=' . $token;
echo $name;
$img = file_get_contents($jpg1);
$img = base64_encode($img);
mysql_connect("localhost","liqinggang","123456");  
mysql_select_db("test");  
mysql_query("set names 'utf8'");  
$sql = "select * from faceuser";
$result = mysql_query($sql);  
$rc =  mysql_affected_rows();  
	$bodys = array(
		'uid' => $rc,
		'user_info' => $name,
		'group_id' => '1',
		'images' => $img
	);
	$res = request_post($url, $bodys);
	var_dump($res);
	$obj = json_decode($res);
	$log_id=strval($obj->{'log_id'});
	print $log_id;
	if(isset($obj->{'error_code'}))
	{
		echo "注册失败，失败码：".$obj->{'error_code'};
	}
	else
	{
		$sql2= "INSERT INTO faceuser VALUES($rc,'$name',1,'$jpg1',$log_id);";
		$result2 = mysql_query($sql2);   
		echo '注册成功';
	}
?> 