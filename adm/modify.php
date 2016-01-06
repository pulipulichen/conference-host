<?php require_once('../Connections/conn.php'); ?>
<?php
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update")) {
  $profession='';
  foreach($_POST['profession'] as $value)
  {
  	if(!isset($first))
	{
		$profession.=$value;
		$first=true;
	}
	else
	{
  		$profession.=','.$value;
	}
  }
  unset($first);
  $updateSQL = sprintf("UPDATE referee SET name=%s, location=%s, affiliation=%s, profession=%s, phone=%s, email=%s, address=%s WHERE ID=%s",
                       GetSQLValueString($_POST['name'], "text"),
					   GetSQLValueString($_POST['location'], "text"),
                       GetSQLValueString($_POST['affiliation'], "text"),
                       GetSQLValueString($_POST['profession'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['id'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  $success=true;
}

$colname_modify = "1";
if (isset($_POST['ID'])) {
  $colname_modify = (get_magic_quotes_gpc()) ? $_POST['ID'] : addslashes($_POST['ID']);
}
mysql_select_db($database_conn, $conn);
$query_modify = sprintf("SELECT * FROM referee WHERE ID = '%s'", $colname_modify);
$modify = mysql_query($query_modify, $conn) or die(mysql_error());
$row_modify = mysql_fetch_assoc($modify);
$totalRows_modify = mysql_num_rows($modify);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>修改審稿委員資料</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style3 {font-size: 12px}
-->
</style></head>

<body>
<?php
	if(isset($success)){
?><center><br><br>
已更新資料!!
<form onSubmit="opener.location.reload();window.close()">
  <input type="submit" name="Submit" value="關閉&重新整理">
</form></center></body></html>
<?php
	exit;
	}
?>
<form action="<?php echo $editFormAction; ?>" method="POST" name="referee" target="_parent" id="referee" onSubmit="return checkForm(this)">
  <table width="550" height="300"  border="0" cellpadding="0" cellspacing="8">
    <tr>
      <td colspan="2"><span class="style3">修改審稿委員資料:</span></td>
    </tr>
    <tr>
      <td width="31%" align="right"><span class="style3">
        <label>姓名:</label>
      </span></td>
      <td width="69%"><input name="name" type="text" id="name" value="<?php echo $row_modify['name']; ?>" size="16"></td>
    </tr>
    <tr>
    <tr>
      <td width="28%" align="right"><span class="style3">
        <label>配給帳號:</label>
      </span></td>
      <td width="72%"><input name="id" type="text" id="id" value="<?php echo $row_modify['ID']; ?>" size="16"></td>
    </tr>
    <td align="right"><span class="style3">
      <label>服務單位</label>
        :</span></td>
        <td><input name="affiliation" type="text" id="affiliation" value="<?php echo $row_modify['affiliation']; ?>" size="32"></td>
    </tr>
          <tr class="content">
            <td align="right"><span class="style3">組別:</span></td>
            <td>              <span class="style3">
              <select name="location" id="location">
                <option value="oral"<?php if(!strcmp('oral',$row_modify['location']))echo ' selected'; ?>>口頭發表組</option>
               
              </select>
            </span> </td>
          </tr>
    <tr>
      <td align="right"><span class="style3">專長:</span></td>
      <td>
  <textarea name="profession" cols="50" rows="10" id="profession" ><?php echo $row_modify['profession']; ?></textarea>
  </td>
    </tr>
    <tr>
      <td align="right"><span class="style3">
        <label>連絡電話:</label>
      </span></td>
      <td><input name="phone" type="text" id="phone" value="<?php echo $row_modify['phone']; ?>" size="32"></td>
    </tr>
    <tr>
      <td align="right"><span class="style3">
        <label>email:</label>
      </span></td>
      <td><input name="email" type="text" id="email" value="<?php echo $row_modify['email']; ?>" size="32"></td>
    </tr>
    <tr>
      <td align="right"><span class="style3">通訊地址:</span></td>
      <td><input name="address" type="text" id="address" value="<?php echo $row_modify['address']; ?>" size="48"></td>
    </tr>
    <tr>
      <td height="21" align="right">&nbsp;</td>
      <td><span class="style3">
        <input type="submit" name="Submit" value="修改">
          <input type="reset" name="Submit" value="重設">
      </span></td>
    </tr>
  </table>
    <input type="hidden" name="MM_update" value="update">
</form>
</body>
</html>
<?php
mysql_free_result($modify);
?>
