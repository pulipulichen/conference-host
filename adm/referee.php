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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "referee")) {
  $profession='';
  foreach($_POST['profession'] as $value) {
    if(!isset($first)) {
      $profession.=$value;
      $first=true;
    }
    else {
      $profession.=','.$value;
    }
  }
  
  unset($first);//echo $profession;exit;
  $insertSQL = sprintf("INSERT INTO referee (ID, password, name, location, affiliation, profession, phone, email, address) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s)",
  GetSQLValueString($_POST['id'], "text"),
  GetSQLValueString(general_password(), "text"),
  GetSQLValueString($_POST['name'], "text"),
  GetSQLValueString($_POST['location'], "text"),
  GetSQLValueString($_POST['affiliation'], "text"),
  GetSQLValueString($_POST['profession'], "text"),
  GetSQLValueString($_POST['phone'], "text"),
  GetSQLValueString($_POST['email'], "text"),
  GetSQLValueString($_POST['address'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());

  $insertGoTo = "referee.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

mysql_select_db($database_conn, $conn);
$query_refree = "SELECT * FROM referee";
$refree = mysql_query($query_refree, $conn) or die(mysql_error());
$row_refree = mysql_fetch_assoc($refree);
$totalRows_refree = mysql_num_rows($refree);
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
  <th class="topic">審稿者資料管理</th>
  <tr>
	<td class="content "><br>
	  <?php if ($totalRows_refree == 0) { // Show if recordset empty ?>
	  未有任何審稿者資料! 請由下方表單新增
	  <?php } // Show if recordset empty ?>
<?php if ($totalRows_refree > 0) { // Show if recordset not empty ?>
	  <table width="100%"  border="1" cellpadding="2" cellspacing="0" bordercolor="#000000">
          <tr bgcolor="#666666">
            <td width="11%"><span class="style3">帳號</span></td>
            <td width="11%"><span class="style3">姓名</span></td>
            <td width="8%"><span class="style3">組別</span></td>
            <td width="8%"><span class="style3">專長</span></td>
            <td width="16%"><span class="style3">服務單位</span></td>
            <td><span class="style3">電話</span></td>
            <td><span class="style3">email</span></td>
            <td><span class="style3">通訊地址</span></td>
            <td><span class="style3">修改</span></td>
            <td><span class="style3">刪除</span></td>
          </tr>
          <?php do { ?>
          <tr bgcolor="#B9D1EA">
            <td><span class="style3"><?php echo $row_refree['id']; ?></span></td>
            <td><span class="style3"><?php echo $row_refree['name']; ?></span></td>
            <td><span class="style3"><?php if(!strcmp('oral',$row_refree['location'])){echo '口頭發表組';}else{echo '網路發表組';} ?></span></td>
            <td><span class="style3"><?php echo $row_refree['profession']; ?></span></td>
            <td><span class="style3"><?php echo $row_refree['affiliation']; ?></span></td>
            <td><span class="style3"><?php echo $row_refree['phone']; ?></span></td>
            <td><span class="style3"><?php echo $row_refree['email']; ?></span></td>
            <td><span class="style3"><?php echo $row_refree['address']; ?></span></td>
            <td><form action="modify.php" method="post" name="modify" target="modify" class="style3" id="modify" onSubmit="popUpWindow('modify.php')">
              <input name="ID" type="hidden" id="ID" value="<?php echo $row_refree['id']; ?>">
              <input type="submit" name="Submit" value="修改">
                          </form></td>
            <td><form action="delete.php" method="post" name="delete" target="_top" class="style3" id="delete" onSubmit="return confirm('確認要刪除這一筆紀錄?');">
              <input name="ID" type="hidden" id="ID" value="<?php echo $row_refree['id']; ?>">
              <input type="submit" name="Submit" value="刪除">
                          </form></td>
          </tr>
        <?php } while ($row_refree = mysql_fetch_assoc($refree)); ?>
      </table>
	  <?php } // Show if recordset not empty ?>
	  <br>
	  <form action="<?php echo $editFormAction; ?>" method="POST" name="referee" class="content" id="referee" onSubmit="return checkForm(this)">
	    <table width="557"  border="0" cellspacing="10" cellpadding="0">
          <tr class="content">
            <td height="12" colspan="2"><span class="style3">新增審稿委員資料:</span></td>
          </tr>
          <tr class="content">
            <td width="21%" align="right">              <span class="style3">
              <label>姓名:</label>
            </span> </td>
            <td width="79%"><input name="name" type="text" id="name" size="16"></td>
          </tr><tr class="content">
            <td width="21%" align="right">              <span class="style3">
              <label>配給帳號:</label>
            </span> </td>
            <td width="79%"><input name="id" type="text" id="id" size="16"></td>
          </tr>
          <tr class="content">
            <td align="right"><span class="style3">組別:</span></td>
            <td>              <span class="style3">
              <select name="location" id="location">
                <option value="oral" selected>口頭發表組</option>
              </select>
            </span> </td>
          </tr>
            <tr class="content"><td align="right">              <span class="style3">
              <label>服務單位</label>
              :</span></td>
            <td><input name="affiliation" type="text" id="affiliation" size="32"></td>
          </tr>
          <tr class="content">
            <td height="176" align="right"><span class="style3">專長:</span></td>
            <td>
			<span class="style3">
                <textarea name="profession" cols="50" rows="10" id="profession"> </textarea>
             </span>			
			 
		    </td>
          </tr>
          <tr class="content">
            <td align="right">              <span class="style3">
              <label>連絡電話:</label>
            </span> </td>
            <td><input name="phone" type="text" id="phone" size="32"></td>
          </tr>
          <tr class="content">
            <td align="right">              <span class="style3">
              <label>email:</label>
            </span> </td>
            <td><input name="email" type="text" id="email" size="32"></td>
          </tr>
          <tr class="content">
            <td align="right"><span class="style3">通訊地址:</span></td>
            <td><input name="address" type="text" id="address" size="48"></td>
          </tr>
          <tr class="content">
            <td align="right">&nbsp;</td>
            <td>              <input type="submit" name="Submit" value="新增">              <input type="reset" name="Submit" value="重設">            </td>
          </tr>
        </table>
	    <input type="hidden" name="MM_insert" value="referee">
	  </form>
	</td>
  </tr>
</table>
</body>
</html>
<?php
mysql_free_result($refree);
?>
