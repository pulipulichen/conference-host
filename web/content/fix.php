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
if (isset($_GET['Paper_serial'])) {
  $colname_fix = (get_magic_quotes_gpc()) ? $_GET['Paper_serial'] : addslashes($_GET['Paper_serial']);
}
mysql_select_db($database_conn, $conn);
$query_fix = sprintf("SELECT * FROM upload WHERE paper_serial = %s", $colname_fix);
$fix = mysql_query($query_fix, $conn) or die(mysql_error());
$row_fix = mysql_fetch_assoc($fix);
$totalRows_fix = mysql_num_rows($fix);

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "update")) {
  $presql="UPDATE upload SET topic=%s, `class`=%s, `group`=%s, contact=%s, affiliation=%s, email=%s, phone=%s, fax=%s, " 
          . "author1=%s, author1_email=%s, author2=%s, author2_email=%s, author3=%s, author3_email=%s, author4=%s, author4_email=%s, author5=%s, author5_email=%s";
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
	if(($ext!='pdf' && $ext!='PDF') || $file_type!='application/pdf') { 
	  $msg.="檔案".$file_name."的類型或檔名錯誤，請重新上傳<br>";
	}
	$upfile="../../upload/".$_SESSION['MM_Username']."/".$row_fix['file_abstract'];
	if(is_uploaded_file($file)) {
	  if(!move_uploaded_file($file,$upfile)) {
		$msg.="伺服器錯誤，檔案".$file_name."無法移至目的，請<a href=\"mailto:taai2005@nuk.edu.tw\">聯絡我們</a>，或稍後再上傳";
	  }
	}
	elseif ($file_error==0) {
	  $msg.="檔案".$file_name."上傳作業遭遇不明錯誤，請<a href=\"mailto:taai2005@nuk.edu.tw\">聯絡我們</a>，或稍後再上傳";
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
	if(($ext!='pdf' && $ext!='PDF') || $file_type!='application/pdf') { 
	  $msg.="檔案".$file_name."的類型或檔名錯誤，請重新上傳<br>";
	}
	$upfile="../../upload/".$_SESSION['MM_Username']."/".$row_fix['file_paper'];
	if(is_uploaded_file($file)) {
	  if(!move_uploaded_file($file,$upfile)) {
		$msg.="伺服器錯誤，檔案".$file_name."無法移至目的，請<a href=\"mailto:taai2005@nuk.edu.tw\">聯絡我們</a>，或稍後再上傳";
	  }
	}
	elseif($file_error=0) {
	  $msg.="檔案".$file_name."上傳作業遭遇不明錯誤，請<a href=\"mailto:taai2005@nuk.edu.tw\">聯絡我們</a>，或稍後再上傳";
	}
	if(isset($success)) {
	  $success.=$_FILES['ulfile']['name'][1]."上傳成功<br>";
	}
	else {
	  $success=$_FILES['ulfile']['name'][1]."上傳成功<br>";
	}
  }
  if($msg=='') {
  $updateSQL = sprintf($presql." WHERE paper_serial=%s",
                       GetSQLValueString($_POST['Topic'], "text"),
                       GetSQLValueString($_POST['Class'], "text"),
                       GetSQLValueString($_POST['Group'], "text"),
                       GetSQLValueString($_POST['contact'], "text"),
                       GetSQLValueString($_POST['Affiliation'], "text"),
                       GetSQLValueString($_POST['Email'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
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
                       GetSQLValueString($_POST['Paper_serial'], "int"));
//echo $updatSQL;
  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($updateSQL, $conn) or die(mysql_error());
  $updateGoTo = "view.php";
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
<title>修改上傳之論文</title>
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
      <th class="topic">論文修改</th>
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
          <?php print $_SESSION['MM_Username']; ?>您好，請選擇所要修改的論文，並填寫修改的論文資訊。
          <input name="Paper_serial" type="hidden" value="<?php print $_GET['Paper_serial']; ?>"></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2">論文題目:</font></td>
          <td colspan="3"><font>
            <input name="Topic" type="text" value="<?php echo $row_fix['topic']; ?>" size ="25">
          </font></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2">投稿類別:</font></td>
          <td colspan="3"><font>
            <select name="Class" size='1' id="Class" >
              <option value="Agents" <?php if (!(strcmp("Agents", $row_fix['class']))) {echo "SELECTED";} ?>>代理人技術 (Agents)</option>
              <option value="Artificial Neural Networks" <?php if (!(strcmp("Artificial Neural Networks", $row_fix['class']))) {echo "SELECTED";} ?>>
                  類神經網路 (Artificial Neural Networks) </option>
              <option value="Automated Reasoning" <?php if (!(strcmp("Automated Reasoning", $row_fix['class']))) {echo "SELECTED";} ?>>推理方法 (Automated Reasoning)</option>
              <option value="Bioinformatics" <?php if (!(strcmp("Bioinformatics", $row_fix['class']))) {echo "SELECTED";} ?>>生物資訊 (Bioinformatics)</option>
              <option value="Computer Vision" <?php if (!(strcmp("Computer Vision", $row_fix['class']))) {echo "SELECTED";} ?>>電腦視覺 (Computer Vision)</option>
              <option value="Data Mining" <?php if (!(strcmp("Data Mining", $row_fix['class']))) {echo "SELECTED";} ?>>資料探勘 (Data Mining)</option>
              <option value="E-Learning" <?php if (!(strcmp("E-Learning", $row_fix['class']))) {echo "SELECTED";} ?>>數位學習 (E-Learning)</option>
              <option value="Evolutionary Computation" <?php if (!(strcmp("Evolutionary Computation", $row_fix['class']))) {echo "SELECTED";} ?>>演化計算 (Evolutionary Computation) </option>
              <option value="Expert Systems" <?php if (!(strcmp("Expert Systems", $row_fix['class']))) {echo "SELECTED";} ?>>專家系統 (Expert Systems)</option>
              <option value="Extenics" <?php if (!(strcmp("Extenics", $row_fix['class']))) {echo "SELECTED";} ?>>可拓工程 (Extenics)</option>
              <option value="Fuzzy Systems" <?php if (!(strcmp("Fuzzy Systems", $row_fix['class']))) {echo "SELECTED";} ?>>模糊系統 (Fuzzy Systems)</option>
              <option value="Grey Theory" <?php if (!(strcmp("Grey Theory", $row_fix['class']))) {echo "SELECTED";} ?>>灰色理論 (Grey Theory)</option>
              <option value="Information Retrieval" <?php if (!(strcmp("Information Retrieval", $row_fix['class']))) {echo "SELECTED";} ?>>資料檢索 (Information Retrieval)</option>
              <option value="Knowledge Base Systems" <?php if (!(strcmp("Knowledge Base Systems", $row_fix['class']))) {echo "SELECTED";} ?>>知識庫系統 (Knowledge Base Systems) </option>
              <option value="Knowledge Engineering" <?php if (!(strcmp("Knowledge Engineering", $row_fix['class']))) {echo "SELECTED";} ?>>知識工程 (Knowledge Engineering)</option>
              <option value="Machine Learning" <?php if (!(strcmp("Machine Learning", $row_fix['class']))) {echo "SELECTED";} ?>>機器學習 (Machine Learning)</option>
              <option value="Natural Language Processing" <?php if (!(strcmp("Natural Language Processing", $row_fix['class']))) {echo "SELECTED";} ?>>自然語言分析 (Natural Language Processing) </option>
              <option value="Pattern Recognition" <?php if (!(strcmp("Pattern Recognition", $row_fix['class']))) {echo "SELECTED";} ?>>圖形識別 (Pattern Recognition)</option>
              <option value="Robotics" <?php if (!(strcmp("Robotics", $row_fix['class']))) {echo "SELECTED";} ?>>智慧型機器人 (Robotics)</option>
              <option value="Rough Sets" <?php if (!(strcmp("Rough Sets", $row_fix['class']))) {echo "SELECTED";} ?>>粗糙集 (Rough Sets)</option>
              <option value="Web Intelligence" <?php if (!(strcmp("Web Intelligence", $row_fix['class']))) {echo "SELECTED";} ?>>網路智慧 (Web Intelligence)</option>
              <option value="Others" <?php if (!(strcmp("Others", $row_fix['class']))) {echo "SELECTED";} ?>>其他 (Others)</option>
              <?php
/*do {  
?>
              <option value="<?php echo $row_fix['class']?>"<?php if (!(strcmp($row_fix['class'], $row_fix['class']))) {echo "SELECTED";} ?>><?php echo $row_fix['class']?></option>
              <?php
} while ($row_fix = mysql_fetch_assoc($fix));
  $rows = mysql_num_rows($fix);
  if($rows > 0) {
      mysql_data_seek($fix, 0);
	  $row_fix = mysql_fetch_assoc($fix);
  }*/
?>
            </select>
          </font></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2">投稿組別:</font></td>
          <td colspan="3"><font>
            <select name="Group" size='1' id="Group" >
              <option value="local" <?php if (!(strcmp("local", $row_fix['group']))) {echo "SELECTED";} ?>>國內組</option>
              <option value="foreign" <?php if (!(strcmp("foreign", $row_fix['group']))) {echo "SELECTED";} ?>>國外組</option>
              <?php
/*do {  
?>
              <option value="<?php echo $row_fix['Group']?>"<?php if (!(strcmp($row_fix['Group'], $row_fix['Group']))) {echo "SELECTED";} ?>><?php echo $row_fix['Group']?></option>
              <?php
} while ($row_fix = mysql_fetch_assoc($fix));
  $rows = mysql_num_rows($fix);
  if($rows > 0) {
      mysql_data_seek($fix, 0);
	  $row_fix = mysql_fetch_assoc($fix);
  }*/
?>
            </select>
          </font></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2">本篇論文聯絡人:</font></td>
          <td colspan="3"><font>
            <input name="contact" type="text" id="contact" value="<?php echo $row_fix['contact']; ?>" size="25">
          </font> </td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font>服務單位:</td>
          <td colspan="3"><font>
            <input name="Affiliation" type="text" id="Affiliation" value="<?php echo $row_fix['affiliation']; ?>"
              size="25">
          </font></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2">e-mail:</font></td>
          <td colspan="3"><font>
            <input name="Email" type="text" value="<?php echo $row_fix['email']; ?>"
              size="25">
          </font></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font size="2"><font color="#FF0000" size="2">*</font>聯絡電話:</font></td>
          <td colspan="3">
              <input name="phone" type="text" id="phone" value="<?php echo $row_fix['phone']; ?>" size="25">
          </td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font size="2">Fax:</font></td>
          <td colspan="3"><font>
            <input name="fax" type="text" id="fax" value="<?php echo $row_fix['fax']; ?>" size="25">
          </font></td>
        </tr>
        <tr class="color">
          <td colspan="2" align="right" nowrap class="content"><font size="2">以下為共同作者:</font></td>
          <td colspan="3">&nbsp;</td>
        </tr>
        <tr class="content">
          <td width="9%" rowspan="2" align="right" valign="top" nowrap class="content">1.</td>
          <td width="14%" align="right" nowrap class="content"><font size="2">論文作者:</font></td>
          <td colspan="3"><font>
            <input name="Author1" type="text" value="<?php echo $row_fix['author1']; ?>" size ="32">
          </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2">E-Mail:</font></td>
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
          <td align="right" nowrap class="content"><font size="2">E-Mail:</font></td>
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
          <td align="right" nowrap class="content"><font size="2">E-Mail:</font></td>
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
          <td align="right" nowrap class="content"><font size="2">E-Mail:</font></td>
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
          <td align="right" nowrap class="content"><font size="2">E-Mail:</font></td>
          <td colspan="3"><font>
            <input name="Author5_email" type="text" id="Author5_email" value="<?php echo $row_fix['author5_email']; ?>" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="color">
          <td colspan="5">
              <span class="style1">注意!</span>檔案上傳只限<span class="style1">pdf</span>檔，上限為<span class="style1">3MB</span>
              謝謝合作 有問題請email：<a href="mialto:taai@nuk.edu.tw">taai2005@nuk.edu.tw</a><br>
          上傳之檔案名稱，除了標示副檔名的&quot;<span class="style1">.pdf</span>&quot;之外，其餘的&quot;.&quot;將會造成傳檔失敗。<br>
          <span class="style1">錯誤範例EX: ai.test.pdf
          </span> </td>
          </tr>
        <tr class="content">
          <td colspan="2" align=right class="content">原論文摘要:</td>
          <td width="20%"><?php echo $row_fix['file_abstract']; ?></td>
          <td width="7%">修改</td>
          <td width="50%"><input name="ulfile[0]"  type="file" size="24"></td>
        </tr>
        <tr class="content">
          <td colspan="2" align=right class="content">原論文全文:</td>
          <td><?php echo $row_fix['file_paper']; ?></td>
          <td>修改</td>
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
