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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "upload")) {
  $msg='';
  for($i=0;$i<2;$i++) {
    $file=$_FILES['ulfile']['tmp_name'][$i];
    $file_name=$_FILES['ulfile']['name'][$i];
    $file_size=$_FILES['ulfile']['size'][$i];
    $file_type=$_FILES['ulfile']['type'][$i];
    $file_error=$_FILES['ulfile']['error'][$i];
    if($file_error>0) {
      switch($file_error) {
        case 1: $msg.="檔案".$file_name."超過最大上傳上限，請確定檔案大小再上傳<br>"; break;
        case 2: $msg.="檔案".$file_name."超過最大表單處理上限，請確定檔案大小再上傳<br>"; break;
        case 3: $msg.="檔案".$file_name."只有部分上傳，請重新上傳<br>"; break;
        case 4: $msg.="沒有上傳檔案".$file_name."，請確認檔案欄位以及上傳之檔案<br>"; break;
      }
    }
    if($file_error==4) {
      @list ($name,$ext) =split ("[.]", $file_name);
    }
    else {
      list ($name,$ext) = split ("[.]", $file_name);
    }
    if(($ext!='pdf' && $ext!='PDF') || $file_type!='application/pdf') { 
      $msg.="檔案".$file_name."的類型或檔名錯誤，請重新上傳<br>";
    }
    if($i==1) {
      $upfile="../../upload/".$_POST['Member']."/paper-";
    }
    else {
      $upfile="../../upload/".$_POST['Member']."/abstract-";
    }
    if(is_uploaded_file($file)) {
      if(!move_uploaded_file($file,$upfile)) {
        $msg.="伺服器錯誤，檔案".$file_name."無法移至目的，請<a href=\"mailto:rank@enjust.com\">聯絡我們</a>，或稍後再上傳";
      }
    }
    elseif($file_error=0) {
      $msg.="檔案".$file_name."上傳作業遭遇不明錯誤，請<a href=\"mailto:rank@enjust.com\">聯絡我們</a>，或稍後再上傳";
    }
    if(isset($success)) {
      $success.=$_FILES['ulfile']['name'][$i]."上傳成功<br>";
    }
    else {
      $success=$_FILES['ulfile']['name'][$i]."上傳成功<br>";
    }
  }
  if($msg=='') {
    $insertSQL = sprintf("INSERT INTO upload (member, topic, `class`, `group`, contact, affiliation, email, phone, fax, " 
            . "author1, author1_email, author2, author2_email, author3, author3_email, author4, author4_email, author5, author5_email) " 
            . "VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
    GetSQLValueString($_POST['Member'], "text"),
    GetSQLValueString($_POST['Topic'], "text"),
    GetSQLValueString($_POST['Class'], "text"),
    GetSQLValueString($_POST['Group'], "text"),
    GetSQLValueString($_POST['Contact'], "text"),
    GetSQLValueString($_POST['Affiliation'], "text"),
    GetSQLValueString($_POST['Email'], "text"),
    GetSQLValueString($_POST['Phone'], "text"),
    GetSQLValueString($_POST['Fax'], "int"),
    GetSQLValueString($_POST['Author1'], "text"),
    GetSQLValueString($_POST['Author1_email'], "text"),
    GetSQLValueString($_POST['Author2'], "text"),
    GetSQLValueString($_POST['Author2_email'], "text"),
    GetSQLValueString($_POST['Author3'], "text"),
    GetSQLValueString($_POST['Author3_email'], "text"),
    GetSQLValueString($_POST['Author4'], "text"),
    GetSQLValueString($_POST['Author4_email'], "text"),
    GetSQLValueString($_POST['Author5'], "text"),
    GetSQLValueString($_POST['Author5_email'], "text"));
    //echo $insertSQL;
    mysql_select_db($database_conn, $conn);
    $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
    $path="../../upload/".$_POST['Member']."/";
    $serialname=mysql_insert_id($conn).".pdf";
    rename($path."abstract-",$path."abstract-".$serialname);
    rename($path."paper-",$path."paper-".$serialname);
    @$totalRows_for_serial = mysql_num_rows($for_serial);
    $updatesql="UPDATE upload SET file_paper='paper-".$serialname."', file_abstract='abstract-".$serialname."' WHERE paper_serial=".$row_for_serial['paper_serial'];
    $Result2=mysql_query($updatesql,$conn);
    @mysql_free_result($for_serial);
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
-->
</style>
</head>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/menu.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/style.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../menuItems.js"></SCRIPT><script language="javascript">
function opwin(){
showModelessDialog ('bar.htm','progress','dialogHeight:100px ; dialogWidth:400px;status:0;help:0;edge:raised;center:yes');
//測試用
setTimeout("upload.submit()",6000);
//正式使用請改為
//form1.submit()
}
<!--
function checkForm(which) {
	var valid=true;
	Emailrxp=/^\S+@\S+\.\S{2,5}$/;
	PhoneFaxrxp=/^\(*\d{2,4}\)*-*\d{5,8}-*\d*$/;
	Topiclabel.style.color="#000000";
	Contactlabel.style.color="#000000";
	Affiliationlabel.style.color="#000000";
	Emaillabel.style.color="#000000";
	Phonelabel.style.color="#000000";
	Faxlabel.style.color="#000000";
	if(!which.Topic.value){
		Topiclabel.style.color="#FF0000";
		valid=false;
	}
	if(!which.Contact.value){
		Contactlabel.style.color="#FF0000";
		valid=false;
	}
	if(!which.Affiliation.value){
		Affiliationlabel.style.color="#FF0000";
		valid=false;
	}
	if(!Emailrxp.exec(which.Email.value)){
		Emaillabel.style.color="#FF0000";
		valid=false;
	}
	if(!PhoneFaxrxp.exec(which.Phone.value)){
		Phonelabel.style.color="#FF0000";
		valid=false;
	}
	if(!PhoneFaxrxp.exec(which.Fax.value) && which.Fax.value){
		Faxlabel.style.color="#FF0000";
		valid=false;
	}
	if(!valid){
		alert("檢查表單中紅色標籤的輸入資料或格式是否正確!");
		return false;
	}else{
		return true;
	}
}
//-->
</script> 
<LINK REL="stylesheet" HREF="../../style/style.css" TYPE="text/css">
<body onLoad="cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice')">
<DIV id="myMenuID"></DIV>
<br><DIV class="scoll">
<center>2013年 第二屆數位合作學習與個人化學習研討會已結束徵稿，感謝您的參與！</center>
<!--<?php //exit; ?>-->
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
      <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="upload" id="upload">
	  <table width=85% border=0 align="center" cellpadding=5 cellspacing=1 class=forumline>
        <tr class="color">
          <td colspan=3><font>
            <input name="Member" type="hidden" id="Member" value="<?php print $_SESSION['MM_Username']; ?>"><?php print $_SESSION['MM_Username']; ?>
          </font>您好，請選擇所要上傳的論文，並填寫論文資訊。</td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2"><label id="Topiclabel" for="Topic">論文題目</label>:</font></td>
          <td width="83%"><font>
            <input type="text" name="Topic" size ="25">
          </font></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2">投稿類別:</font></td>
          <td><font>
            <select name="Class" size='1' id="Class" >
              <option value="多元文化及特殊教育" selected>多元文化及特殊教育</option>
              <option value="高等教育">高等教育</option>
              <option value="人文藝術教育">人文藝術教育</option>
              <option value="幼兒及家庭教育">幼兒及家庭教育</option>
              <option value="師資培育">師資培育</option>
              <option value="教育行政與政策">教育行政與政策</option>
              <option value="課程與教學">課程與教學</option>
              <option value="科學教育">科學教育</option>
              <option value="數學及資訊教育">數學及資訊教育</option>
            </select>
          </font></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2">投稿組別:</font></td>
          <td><font>
            <select name="Group" size='1' id="Group" >
              <option value="oral" selected>口頭發表組</option>
              <option value="network">網路發表組</option>
            </select>
          </font></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2"><label id="Contactlabel" for="Contact">本篇論文聯絡人</label>:</font></td>
          <td><font>
            <input name="Contact" type="text" id="Contact" size="25">
          </font> </td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content">
              <font color="#FF0000" size="2">*</font>
              <label id="Affiliationlabel" for="Affiliation">服務單位</label>:
          </td>
          <td><font>
            <input name="Affiliation" type="text" id="Affiliation"
              size="25">
          </font></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content"><font color="#FF0000" size="2">*</font><font size="2"><label id="Emaillabel" for="Email">e-mail</label>:</font></td>
          <td><font>
            <input type="text" name="Email"
              size="25">
          </font></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content">
              <font size="2"><font color="#FF0000" size="2">*</font><label id="Phonelabel" for="Phone">聯絡電話</label>:</font></td>
          <td><input name="Phone" type="text" id="Phone" size="25"></td>
        </tr>
        <tr class="content">
          <td colspan="2" align="right" nowrap class="content">
              <font size="2"><label id="Faxlabel" for="Fax">Fax</label>:</font></td>
          <td><font>
            <input name="Fax" type="text" id="Fax" size="25">
          </font></td>
        </tr>
        <tr class="color">
          <td colspan="2" align="right" nowrap class="content"><font size="2">以下為共同作者:</font></td>
          <td>&nbsp;</td>
        </tr>
        <tr class="content">
          <td width="4%" rowspan="2" align="right" nowrap class="content">1.</td>
          <td width="13%" align="right" nowrap class="content"><font size="2">論文作者:</font></td>
          <td><font>
            <input type="text" name="Author1" size ="32">
          </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2">E-Mail:</font></td>
          <td><font>
            <input name="Author1_email" type="text" id="Author1_email" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td rowspan="2" align="right" nowrap class="content">2.</td>
          <td align="right" nowrap class="content"><font size="2">論文作者:</font></td>
          <td><font>
            <input name="Author2" type="text" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2">E-Mail:</font></td>
          <td><font>
            <input name="Author2_email" type="text" id="Author2_email" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td rowspan="2" align="right" nowrap class="content">3.</td>
          <td align="right" nowrap class="content"><font size="2">論文作者:</font></td>
          <td><font>
            <input type="text" name="Author3" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2">E-Mail:</font></td>
          <td><font>
            <input name="Author3_email" type="text" id="Author3_email" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td rowspan="2" align="right" nowrap class="content">4.</td>
          <td align="right" nowrap class="content"><font size="2">論文作者:</font></td>
          <td><font>
            <input type="text" name="Author4" size ="32">
            <font color="#FFFFFF"> hu</font> </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2">E-Mail:</font></td>
          <td><font>
            <input name="Author4_email" type="text" id="Author4_email" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td rowspan="2" align="right" nowrap class="content">5.</td>
          <td align="right" nowrap class="content"><font size="2">論文作者:</font></td>
          <td><font>
            <input type="text" name="Author5" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2">E-Mail:</font></td>
          <td><font>
            <input name="Author5_email" type="text" id="Author5_email" size ="32">
            　 
          </font></td>
        </tr>
        <tr class="color">
          <td colspan="3"><span class="style1">注意!</span>檔案上傳只限<span class="style1">pdf</span>檔，上限為<span class="style1">3MB</span>謝謝合作 有問題請洽 [<a href="mialto:rank@enjust.com">網站管理員</a> ]<br>
          上傳之檔案名稱，除了標示副檔名的&quot;<span class="style1">.pdf</span></font>&quot;之外，其餘的&quot;.&quot;將會造成傳檔失敗。<br>
          <span class="style1">錯誤範例EX: ai.test.pdf
          </span> </td>
          </tr>
        <tr class="content">
          <td colspan="2" align=right class="content">論文摘要:</td>
          <td><input name="ulfile[]"  type="file" size="32"></td>
        </tr>
        <tr class="content">
          <td colspan="2" align=right class="content">論文全文:</td>
          <td><input name="ulfile[]" type="file" size="32"></td>
        </tr>
        <tr class="content">
          <td colspan="2"></td>
          <td>            <input type="SUBMIT" VALUE="送出">              　
                <input type="RESET" VALUE="清除重填"></td></tr>
      </table>
      <input type="hidden" name="MM_insert" value="upload">
      </form>
	    <div align="right"><br>
	      <a href="logout.php" target="_top">登出</a></div></td>
  </tr>
</table>
</DIV></DIV>
</body>
</html>
<?php
/*
Warning: mysql_num_rows(): supplied argument is not a valid MySQL result resource in C:\AppServ\www\web\big5\content\upload.php on line 150

Warning: mysql_free_result(): supplied argument is not a valid MySQL result resource in C:\AppServ\www\web\big5\content\upload.php on line 175
*/
?>