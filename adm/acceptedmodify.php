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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "modify")) {
  $updateSQL = sprintf("UPDATE upload SET Topic=%s, `Class`=%s, `Group`=%s, Author1=%s, Author1_email=%s, Author2=%s, Author2_email=%s, Author3=%s, Author3_email=%s, Author4=%s, Author4_email=%s, Author5=%s, Author5_email=%s, Author6=%s, Author6_email=%s WHERE Paper_serial=%s",
                       GetSQLValueString($_POST['Topic'], "text"),
                       GetSQLValueString($_POST['Class'], "text"),
                       GetSQLValueString($_POST['Group'], "text"),
                       GetSQLValueString($_POST['Author1'], "text"),
                       GetSQLValueString($_POST['Author1_email'], "text"),
                       GetSQLValueString($_POST['Author2'], "text"),
                       GetSQLValueString($_POST['Author2_email'], "text"),
                       GetSQLValueString($_POST['Author3'], "text"),
                       GetSQLValueString($_POST['Author3_email'], "text"),
                       GetSQLValueString($_POST['Author4'], "text"),
                       GetSQLValueString($_POST['Author4_email'], "text"),
                       GetSQLValueString($_POST['Author5'], "text"),
                       GetSQLValueString($_POST['Author5_email'], "text"),
                       GetSQLValueString($_POST['Author6'], "text"),
                       GetSQLValueString($_POST['Author6_email'], "text"),
                       GetSQLValueString($_POST['Paper_serial'], "int"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());

  $updateGoTo = "acceptedlist.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_paper = "1";
if (isset($_POST['Paper_serial'])) {
  $colname_paper = (get_magic_quotes_gpc()) ? $_POST['Paper_serial'] : addslashes($_POST['Paper_serial']);
}
mysql_select_db($database_conn, $conn);
$query_paper = sprintf("SELECT * FROM upload WHERE Paper_serial = %s", $colname_paper);
$paper = mysql_query($query_paper, $conn) or die(mysql_error());
$row_paper = mysql_fetch_assoc($paper);
$totalRows_paper = mysql_num_rows($paper);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>無標題文件</title>
</head>

<body>
<form action="<?php echo $editFormAction; ?>" method="POST" name="modify" id="modify">
  <table width="100%"  border="0" cellspacing="5" cellpadding="5">
    <tr>
      <td colspan="2"><div align="right">論文編號：</div></td>
      <td width="85%"><?php echo $row_paper['Paper_serial']; ?>
        
      <input type="hidden" name="Paper_serial" value="<?php echo $row_paper['Paper_serial']; ?>"></td>
    </tr>
    <tr>
      <td colspan="2"><div align="right">論文標題：</div></td>
      <td><input name="Topic" type="text" id="Topic" value="<?php echo $row_paper['Topic']; ?>" size="64">
      </td>
    </tr>
    <tr>
      <td colspan="2"><div align="right">類別：</div></td>
      <td><select name="Class" size='1' id="Class" >
        <option value="CSCL">CSCL</option>
        <option value="CSPL">CSPL</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="2"><div align="right">組別：</div></td>
      <td><select name="Group" size='1' id="Group" >
              <option value="oral"<?php if (!strcmp("oral", $row_paper['Group'])) {echo " SELECTED";} ?>>口頭發表組</option>
      </select></td>
    </tr>
    <tr>
      <td colspan="3" bgcolor="#CCCCCC"><strong>作者</strong></td>
    </tr>
    <tr>
      <td width="5%" rowspan="2"><div align="right">1.</div></td>
      <td width="10%"><div align="right">姓名：</div></td>
      <td>
      <input name="Author1" type="text" id="Author1" value="<?php echo $row_paper['Author1']; ?>"></td>
    </tr>
    <tr>
      <td><div align="right">服務單位：</div></td>
      <td>
      <input name="Author1_email" type="text" id="Author1_email" value="<?php echo $row_paper['Author1_email']; ?>"></td>
    </tr>
    <tr>
      <td rowspan="2"><div align="right">2.</div></td>
      <td><div align="right">姓名：</div></td>
      <td>
      <input name="Author2" type="text" id="Author2" value="<?php echo $row_paper['Author2']; ?>"></td>
    </tr>
    <tr>
      <td><div align="right">服務單位：</div></td>
      <td>
      <input name="Author2_email" type="text" id="Author2_email" value="<?php echo $row_paper['Author2_email']; ?>"></td>
    </tr>
    <tr>
      <td rowspan="2"><div align="right">3.</div></td>
      <td><div align="right">姓名：</div></td>
      <td>
      <input name="Author3" type="text" id="Author3" value="<?php echo $row_paper['Author3']; ?>"></td>
    </tr>
    <tr>
      <td><div align="right">服務單位：</div></td>
      <td>
      <input name="Author3_email" type="text" id="Author3_email" value="<?php echo $row_paper['Author3_email']; ?>"></td>
    </tr>
    <tr>
      <td rowspan="2"><div align="right">4.</div></td>
      <td><div align="right">姓名：</div></td>
      <td>
      <input name="Author4" type="text" id="Author4" value="<?php echo $row_paper['Author4']; ?>"></td>
    </tr>
    <tr>
      <td><div align="right">服務單位：</div></td>
      <td>
      <input name="Author4_email" type="text" id="Author4_email" value="<?php echo $row_paper['Author4_email']; ?>"></td>
    </tr>
    <tr>
      <td rowspan="2"><div align="right">5.</div></td>
      <td><div align="right">姓名：</div></td>
      <td>
      <input name="Author5" type="text" id="Author5" value="<?php echo $row_paper['Author5']; ?>"></td>
    </tr>
    <tr>
      <td><div align="right">服務單位：</div></td>
      <td><input name="Author5_email" type="text" id="Author5_email" value="<?php echo $row_paper['Author5_email']; ?>"></td>
    </tr>
    <tr>
      <td rowspan="2"><div align="right">6.</div></td>
      <td><div align="right">姓名：</div></td>
      <td>
      <input name="Author6" type="text" id="Author6" value="<?php echo $row_paper['Author6']; ?>"></td>
    </tr>
    <tr>
      <td><div align="right">服務單位：</div></td>
      <td><input name="Author6_email" type="text" id="Author6_email" value="<?php echo $row_paper['Author6_email']; ?>"></td>
    </tr>
  </table>
  <p>　　　　　　　
    <input type="submit" name="Submit" value="送出">
    <input type="reset" name="Submit" value="重設">
  </p>
  <input type="hidden" name="MM_update" value="modify">
</form>
</body>
</html>
<?php
mysql_free_result($paper);
?>
