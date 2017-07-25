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
if ((($_FILES["file"]["type"] == "image/jpg")
|| ($_FILES["file"]["type"] == "image/jpeg")
|| ($_FILES["file"]["type"] == "image/pjpeg"))
&& ($_FILES["file"]["size"] < 20000000))
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
	
    }
  }
else
  {
 	 echo "<script>alert('图片一上传失败！');history.go(-1);</script>";  
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
      }
    else
      {
      move_uploaded_file($_FILES["file"]["tmp_name"],
      "upload/" . $_FILES["file"]["name"]);
     // echo "Stored in: " . "upload/" . $_FILES["file"]["name"];
      }
    }
  }
else
  {
   		 echo "<script>alert('图片一保存失败！');history.go(-1);</script>";  
  }
	//保存路径
	$jpg1= "upload/" . $_FILES["file"]["name"];
?>




<?php
//文件上传
if ($_FILES["file2"]["error"] > 0)
  {
  echo "Error: " . $_FILES["file2"]["error"] . "<br />";
  }
else
  {
 /* echo "Upload: " . $_FILES["file2"]["name"] . "<br />";
  echo "Type: " . $_FILES["file2"]["type"] . "<br />";
  echo "Size: " . ($_FILES["file2"]["size"] / 1024) . " Kb<br />";
  echo "Stored in: " . $_FILES["file2"]["tmp_name"];*/
  }
//上传限制
if ((($_FILES["file2"]["type"] == "image/jpg")
|| ($_FILES["file2"]["type"] == "image/jpeg")
|| ($_FILES["file2"]["type"] == "image/pjpeg"))
&& ($_FILES["file2"]["size"] < 20000000))
  {
  if ($_FILES["file2"]["error"] > 0)
    {
    echo "Error: " . $_FILES["file2"]["error"] . "<br />";
    }
  else
    {
  /*  echo "Upload: " . $_FILES["file2"]["name"] . "<br />";
    echo "Type: " . $_FILES["file2"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file2"]["size"] / 1024) . " Kb<br />";
    echo "Stored in: " . $_FILES["file2"]["tmp_name"];*/
    }
  }
else
  {
 	 echo "<script>alert('图片二上传失败！');history.go(-1);</script>";  
  }
//保存文件
if ((($_FILES["file2"]["type"] == "image/jpg")
|| ($_FILES["file2"]["type"] == "image/jpeg")
|| ($_FILES["file2"]["type"] == "image/pjpeg"))
&& ($_FILES["file2"]["size"] < 20000000))
  {
  if ($_FILES["file2"]["error"] > 0)
    {
    echo "Return Code: " . $_FILES["file2"]["error"] . "<br />";
    }
  else
    {
  /*  echo "Upload: " . $_FILES["file2"]["name"] . "<br />";
    echo "Type: " . $_FILES["file2"]["type"] . "<br />";
    echo "Size: " . ($_FILES["file2"]["size"] / 1024) . " Kb<br />";
    echo "Temp file2: " . $_FILES["file2"]["tmp_name"] . "<br />";
*/
    if (file_exists("upload/" . $_FILES["file2"]["name"]))
      {
      //echo $_FILES["file2"]["name"] . " already exists. ";
      }
    else
      {
      move_uploaded_file($_FILES["file2"]["tmp_name"],
      "upload/" . $_FILES["file2"]["name"]);
     // echo "Stored in: " . "upload/" . $_FILES["file2"]["name"];
      }
    }
  }
else
  {
	  echo '图片二保存成功';;
  }
  //保存路径
	$jpg2= "upload/" . $_FILES["file2"]["name"];
?>




<?php

//post请求
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

//关键参数
$token = $_SESSION['token'];
$url = 'https://aip.baidubce.com/rest/2.0/face/v2/match?access_token=' . $token;


//实现逻辑
$img = file_get_contents($jpg1);
$img = base64_encode($img);
$img1 = file_get_contents($jpg2);
$img1 = base64_encode($img1);
$bodys = array(
    "images" => implode(',', array($img, $img1))
);
$res = request_post($url, $bodys);
$obj = json_decode($res);
if($obj->{'result'}[0]->score>80)
{
	print '是同一个人';
	
}
else
{
	print '不是同一个人';
}
echo "";
print '相似度为'.$obj->{'result'}[0]->score;
?>