<?php require_once('../../Connections/conn.php'); ?>
<?php
session_start();
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "login.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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

$colname_fix = "0";
if (isset($_POST['Paper_serial'])) {
  $colname_fix = (get_magic_quotes_gpc()) ? $_POST['Paper_serial'] : addslashes($_POST['Paper_serial']);
}
mysql_select_db($database_conn, $conn);
$query_fix = sprintf("SELECT * FROM upload WHERE paper_serial = %s", $colname_fix);
$fix = mysql_query($query_fix, $conn) or die(mysql_error());
$row_fix = mysql_fetch_assoc($fix);
$totalRows_fix = mysql_num_rows($fix);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update")) {
  $abstract = "csclcspl_abstract_$colname_fix.doc";	// Final 摘要檔名
  $paper = "csclcspl_paper_$colname_fix.doc";	// Final 論文檔名
  $msg='';
  if(isset($_FILES['ulfile']['tmp_name'][0]) && $_FILES['ulfile']['error'][0]!=4) {
    $file=$_FILES['ulfile']['tmp_name'][0];
	$file_name=$_FILES['ulfile']['name'][0];
	$file_size=$_FILES['ulfile']['size'][0];
	$file_type=$_FILES['ulfile']['type'][0];
	$file_error=$_FILES['ulfile']['error'][0];
	if($file_error>0) {
	  switch($file_error) {
	  	case 1: $msg.="檔案".$file_name."超過最大上傳上限，請確定檔案大小再上傳<br>"; break;
		case 2: $msg.="檔案".$file_name."超過最大表單處理上限，請確定檔案大小再上傳<br>"; break;
		case 3: $msg.="檔案".$file_name."只有部分上傳，請重新上傳<br>"; break;
	  }
	}
	list ($name,$ext) = split ("[.]", $file_name);
	if(($ext!='doc' && $ext!='DOC') || $file_type!='application/msword') { 
	  $msg.="檔案".$file_name."的類型或檔名錯誤，請重新上傳<br>";
	}
	// $upfile="../../upload/".$_SESSION['MM_Username']."/ntec-".$row_fix['file_abstract'];
	$upfile="../../upload/".$_SESSION['MM_Username']."/$abstract";	// 上傳摘要檔
	if(is_uploaded_file($file)) {
	  if(!move_uploaded_file($file,$upfile)) {
		$msg.="伺服器錯誤，檔案".$file_name."無法移至目的，請<a href=\"mailto:csclcspl2013@gmail.com\">聯絡我們</a>，或稍後再上傳";
	  }
	}
	elseif($file_error=0) {
	  $msg.="檔案".$file_name."上傳作業遭遇不明錯誤，請<a href=\"mailto:csclcspl2013@gmail.com\">聯絡我們</a>，或稍後再上傳";
	}
	if(isset($success)) {
	  $success.=$_FILES['ulfile']['name'][0]."上傳成功<br>";
	}
	else {
	  $success=$_FILES['ulfile']['name'][0]."上傳成功<br>";
	}
  }
  if(isset($_FILES['ulfile']['tmp_name'][1]) && $_FILES['ulfile']['error'][1]!=4) {
    $file=$_FILES['ulfile']['tmp_name'][1];
	$file_name=$_FILES['ulfile']['name'][1];
	$file_size=$_FILES['ulfile']['size'][1];
	$file_type=$_FILES['ulfile']['type'][1];
	$file_error=$_FILES['ulfile']['error'][1];
	if($file_error>0) {
	  switch($file_error) {
	  	case 1: $msg.="檔案".$file_name."超過最大上傳上限，請確定檔案大小再上傳<br>"; break;
		case 2: $msg.="檔案".$file_name."超過最大表單處理上限，請確定檔案大小再上傳<br>"; break;
		case 3: $msg.="檔案".$file_name."只有部分上傳，請重新上傳<br>"; break;
	  }
	}
	list ($name,$ext) = split ("[.]", $file_name);
	if(($ext!='doc' && $ext!='DOC') || $file_type!='application/msword') { 
	  $msg.="檔案".$file_name."的類型或檔名錯誤，請重新上傳<br>";
	}
	// $upfile="../../upload/".$_SESSION['MM_Username']."/ntec-".$row_fix['file_paper'];
	$upfile="../../upload/".$_SESSION['MM_Username']."/$paper";	// 上傳論文檔
	if(is_uploaded_file($file)) {
	  if(!move_uploaded_file($file,$upfile)) {
		$msg.="伺服器錯誤，檔案".$file_name."無法移至目的，請<a href=\"mailto:csclcspl2013@gmail.com\">聯絡我們</a>，或稍後再上傳";
	  }
	}
	elseif($file_error=0) {
	  $msg.="檔案".$file_name."上傳作業遭遇不明錯誤，請<a href=\"mailto:csclcspl2013@gmail.com\">聯絡我們</a>，或稍後再上傳";
	}
	if(isset($success)) {
	  $success.=$_FILES['ulfile']['name'][1]."上傳成功<br>";
	}
	else {
	  $success=$_FILES['ulfile']['name'][1]."上傳成功<br>";
	}
  }
  if($msg=='') {
  $presql="UPDATE upload SET author1=%s, author1_email=%s, author2=%s, author2_email=%s, author3=%s, author3_email=%s, author4=%s, author4_email=%s, author5=%s, author5_email=%s, file_paper=%s, file_abstract=%s, camready='y'";
  $updateSQL = sprintf($presql." WHERE paper_serial=%s",
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
                       GetSQLValueString($paper, "text"),
                       GetSQLValueString($abstract, "text"),
                       GetSQLValueString($_POST['Paper_serial'], "int"));
//echo $updatSQL;
  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  $updateGoTo = "finalview.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>論文完稿上傳</title>
<style type="text/css">
<!--
.style1 {color: #FF0000}
.format {
	border: 2px inset;
	width: 236px;
	height: 22px;
	background-color: #FFFFFF;
	font-size: 13px;
	padding: 1px;
}
.style5 {color: #FF0000; font-weight: bold; }
-->
</style>
</head>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/menu.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/style.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../menuItems.js"></SCRIPT><script language="javascript">
function opwin(){
showModelessDialog ('bar.htm','progress','dialogHeight:100px ; dialogWidth:400px;status:1;help:0;edge:raised;center:yes');
//測試用
setTimeout("upload.submit()",6000);
//正式使用請改為
//form1.submit()
}
</script>
<LINK REL="stylesheet" HREF="../../style/style.css" TYPE="text/css">
<body onLoad="cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice')">
<DIV id="myMenuID"></DIV>
<br><DIV class="scoll">
<table width=100% border=0 cellspacing=10>
          <th class="topic">論文完稿上傳</th>
  <tr>
	<td class="content"><br>
<?php
if(isset($msg) && $msg!='') {
  echo "<b>$msg</b><br>";
}
else {
  if(isset($success)) {
	echo "<div align=\"center\">".$success."<a href=\"view.php\">檢視</a>上傳論文結果</div></td></tr></table></DIV></body></html>";
	exit;
  }
}
?>
      <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="update" id="update" onSubmit="opwin()">
	  <table width=85% border=0 align="center" cellpadding=5 cellspacing=1 class=forumline>
        <tr class="color">
          <td colspan=5><font>
          <?php print $_SESSION['MM_Username']; ?>您好，請選擇所要上傳的論文檔案，並依需要修改論文資訊。
          <input name="Paper_serial" type="hidden" value="<?php print $_POST['Paper_serial']; ?>"></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2">論文題目:</font></td>
          <td colspan="3"><?php echo $row_fix['topic']; ?></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2">投稿類別:</font></td>
          <td colspan="3"><?php echo $row_fix['class']; ?></td>
        </tr>
        
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2">本篇論文聯絡人:</font></td>
          <td colspan="3"><?php echo $row_fix['contact']; ?></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font>服務單位:</td>
          <td colspan="3"><?php echo $row_fix['affiliation']; ?></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2">e-mail:</font></td>
          <td colspan="3"><?php echo $row_fix['email']; ?></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font size="2"><font color="#FF0000" size="2">*</font>聯絡電話:</font></td>
          <td colspan="3"><?php echo $row_fix['phone']; ?></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font size="2">Fax:</font></td>
          <td colspan="3"><?php echo $row_fix['fax']; ?></td>
        </tr>
        <tr class="color">
          <td colspan="2" align="right" nowrap class="content"><font size="2">作者:</font></td>
          <td colspan="3" class="style1">請務必確實填寫論文作者資料!</td>
        </tr>
        <tr class="content">
          <td width="15%" rowspan="2" align="right" valign="top" nowrap class="content">1.</td>
          <td width="21%" align="right" nowrap class="content"><font size="2">論文作者:</font></td>
          <td colspan="3"><font>
            <input name="Author1" type="text" value="<?php echo $row_fix['author1']; ?>" size ="32">
          </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2">服務單位:</font></td>
          <td colspan="3"><font>
            <input name="Author1_email" type="text" id="Author1_email" value="<?php echo $row_fix['author1_email']; ?>" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td rowspan="2" align="right" valign="top" nowrap class="content">2.</td>
          <td align="right" nowrap class="content"><font size="2">論文作者:</font></td>
          <td colspan="3"><font>
            <input name="Author2" type="text" value="<?php echo $row_fix['author2']; ?>" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2"><font size="2">服務單位</font>:</font></td>
          <td colspan="3"><font>
            <input name="Author2_email" type="text" id="Author2_email" value="<?php echo $row_fix['author2_email']; ?>" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td rowspan="2" align="right" valign="top" nowrap class="content">3.</td>
          <td align="right" nowrap class="content"><font size="2">論文作者:</font></td>
          <td colspan="3"><font>
            <input name="Author3" type="text" value="<?php echo $row_fix['author3']; ?>" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2"><font size="2">服務單位</font>:</font></td>
          <td colspan="3"><font>
            <input name="Author3_email" type="text" id="Author3_email" value="<?php echo $row_fix['author3_email']; ?>" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td rowspan="2" align="right" valign="top" nowrap class="content">4.</td>
          <td align="right" nowrap class="content"><font size="2">論文作者:</font></td>
          <td colspan="3"><font>
            <input name="Author4" type="text" value="<?php echo $row_fix['author4']; ?>" size ="32">
            <font color="#FFFFFF"> hu</font> </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2"><font size="2">服務單位</font>:</font></td>
          <td colspan="3"><font>
            <input name="Author4_email" type="text" id="Author4_email" value="<?php echo $row_fix['author4_email']; ?>" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td rowspan="2" align="right" valign="top" nowrap class="content">5.</td>
          <td align="right" nowrap class="content"><font size="2">論文作者:</font></td>
          <td colspan="3"><font>
            <input name="Author5" type="text" value="<?php echo $row_fix['author5']; ?>" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2"><font size="2">服務單位</font>:</font></td>
          <td colspan="3"><font>
            <input name="Author5_email" type="text" id="Author5_email" value="<?php echo $row_fix['author5_email']; ?>" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="color">
          <td colspan="5"><p><span class="style1">注意!</span>檔案上傳只限<span class="style1"><strong>doc</strong></span><span class="style5">(Microsoft Word 97-2003格式)</span>檔，上限為<span class="style1">3MB</span>謝謝合作 有問題請email：<a href="mailto:csclcspl2013@gmail.com">csclcspl2013@gmail.com</a><br>
            上傳之檔案名稱，除了標示副檔名的&quot;<span class="style1">.doc</span>&quot;之外，其餘的&quot;.&quot;將會造成傳檔失敗。<br>
                <span class="style1">錯誤範例EX: ai.test.doc              </span> </p>
            <p><img src="../../images/972003doc.gif" width="1004" height="210"></p></td>
          </tr>
        <tr class="content">
          <td colspan="2" align=right class="content">論文摘要:</td>
          <td width="64%"><input name="ulfile[0]"  type="file" size="24"></td>
        </tr>
        <tr class="content">
          <td colspan="2" align=right class="content">論文全文:</td>
          <td><input name="ulfile[1]" type="file" size="24"></td>
        </tr>
        <tr class="content">
          <td colspan="2"></td>
          <td colspan="3">            <input type="SUBMIT" VALUE="送出">              　
                <input type="RESET" VALUE="清除重填"></td></tr>
      </table>
      <input type="hidden" name="MM_update" value="upload">
      <input type="hidden" name="MM_update" value="update">
      </form>
	    <div align="right"><br>
	      <a href="logout.php" target="_top">登出</a></div></td>
  </tr>
</table></DIV>
</body>
</html>
<?php
//mysql_free_result($fix);