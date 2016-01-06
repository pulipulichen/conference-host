<?php require_once('../Connections/conn.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
  $theValue = (!get_magic_quotes_gpc()) ? addslashes($theValue) : $theValue;

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

function general_password($nSize=8) {
  $password='';
  for($i=0;$i<$nSize;$i++) {
    $nRandom=mt_rand(1,20);
    if($nRandom<11) {
      $password.=chr(mt_rand(97,122));
    }
    else {
      $password.=mt_rand(0,9);
    }
  }
  return $password;
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "receipt_update")) {
  
  
    
//將所有資料設定為未確認N
   $SQL = "UPDATE receipt SET Confirmed ='N'";
   mysql_select_db($database_conn, $conn);
   $Result1 = mysql_query($SQL, $conn) or die(mysql_error());
   
   //判斷有勾選的會員Y
   foreach($_POST['paid_chk'] as $value){
     $SQL = "UPDATE receipt SET Confirmed ='Y' where memberid='".$value."'";
     mysql_select_db($database_conn, $conn);
     $Result1 = mysql_query($SQL, $conn) or die(mysql_error());
	}
   
   
  $insertGoTo = "receipt_adm.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));

}

mysql_select_db($database_conn, $conn);
$query_receipt = "SELECT * FROM receipt group by s";
$receipt = mysql_query($query_receipt, $conn) or die(mysql_error());
$row_receipt = mysql_fetch_assoc($receipt);
$totalRows_receipt = mysql_num_rows($receipt);
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>審稿者資料管理</title>
<script language="JavaScript">
<!--
var modify=0;
function popUpWindow(URLStr, left, top, width, height)
{
  var width="600", height="500";
  var left = (screen.width/2) - width/2;
  var top = (screen.height/2) - height/2;
  if(modify)
  {
    if(!modify.closed) modify.close();
  }
  modify = open(URLStr, 'modify', 'toolbar=no,location=no,directories=no,status=no,menub ar=no,scrollbar=no,resizable=no,copyhistory=yes,width='+width+',height='+height+',left='+left+', top='+top+',screenX='+left+',screenY='+top+'');
}
//-->
</script> 
<style type="text/css">
<!--
.style3 {font-size: 12px}
-->
</style>
</head>
<body>
<br>
<table width=100% border=0 cellspacing=10>
  <th class="topic">報名帳款資料管理</th>
  <tr>
	<td class="content "><br>
	  
<?php if ($totalRows_receipt > 0) { // Show if recordset not empty ?>
<form name="form1" method="post" action="">
    <table width="1777"  border="1" cellpadding="2" cellspacing="0" bordercolor="#000000">
      <tr bgcolor="#666666">
        <td width="80" bgcolor="#999999">報名順序</td>
        <td width="175" bgcolor="#999999">會員帳號</td>
        <td width="181" bgcolor="#999999">身分別</td>
        <td width="156" bgcolor="#999999">聯絡人</td>
        <td width="257" bgcolor="#999999"><span class="style3">E-mail</span></td>
        <td width="302" bgcolor="#999999">備註</td>
        <td width="190" bgcolor="#999999">收據上傳時間</td>
        <td width="157" bgcolor="#999999">收據檔案</td>
        <td width="223" bgcolor="#999999"><span class="style3">繳款狀態(確認帳款後請打勾後按下更新)</span></td>
      </tr>
      <?php do { ?>
      <tr bgcolor="#B9D1EA">
        <td><center><font color=red><b><?php echo $row_receipt['s']; ?></b></font></center></td>
        
        <td height="70"><span class="style3"><?php echo $row_receipt['memberid']; ?></span></td>
		<?php 
		//身分別判斷(作者(至少一篇/一般(無投稿))
		if($row_receipt['paper']=="Y")
		 $paper="<font color=red><b>作者(至少投稿一篇)</font>";
		else
		 $paper="<font color=blue><b>一般(無投稿)</font>";		
		 
		 $path="../upload/".$row_receipt['memberid']."/";
		 $filename = glob($path."receipt.*");
		?>
        <td><span class="style3"><?php echo $paper; ?></span></td>
        <td><span class="style3"><?php echo $row_receipt['contact']; ?></span></td>
        <td><span class="style3"><?php echo $row_receipt['email']; ?></span></td>
		<td><span class="style3"><?php echo $row_receipt['memo']; ?></span></td>
        <td><span class="style3"><?php echo $row_receipt['uploadtime']; ?></span></td>
		<td><a href="<?php echo $filename[0]; ?>" target="_blank" class="style3">點此查看收據</a></td>
		<?php 
		//帳款確認功能
		 if($row_receipt['Confirmed']=='Y')
		 $paid="checked";
		 else
		 $paid="";
		?>
        <td><span class="style3"></span>
            <label>
              <input name="paid_chk[]" type="checkbox" value=<?php echo $row_receipt['memberid']; ?> <?php echo $paid ?>>
              <span class="style3">對帳完成              </span></label>
		      <span class="style3"></span></span> </td>
      </tr>
      <?php } while ($row_receipt = mysql_fetch_assoc($receipt)); ?>
    </table>
    <?php } // Show if recordset not empty ?>
	  <input type="hidden" name="MM_update" value="receipt_update">
	 <p align=right><input type="submit" name="submit_receipt" value="更新">
</form>
	  
</body>
</html>
<?php
mysql_free_result($receipt);
?>
