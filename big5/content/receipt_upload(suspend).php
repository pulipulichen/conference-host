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


//檔案上傳

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "upload")) {
    $msg='';  
	$path = glob("../../upload/".$_SESSION['MM_Username']."/receipt.*");  //讀取舊有檔案	
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
        case 4: $msg.="沒有上傳檔案".$file_name."，請確認檔案欄位以及上傳之檔案<br>"; break;
      }
    }
    
	if($file_error==4) {
      @list ($name,$ext) =split ("[.]", $file_name);
    }
    else {
      list ($name,$ext) = split ("[.]", $file_name);
    }
    
	 $upfile="../../upload/".$_POST['memberid']."/receipt.".$ext;
    
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
  
//新增資料到資料庫
 
 if($msg=='') {
  
  if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "upload")) {

//查詢是否有投稿
mysql_select_db($database_conn, $conn);
$query_view = sprintf("SELECT * FROM upload WHERE Member = '" . $_SESSION['MM_Username'] ."'", $colname_view);
$view = mysql_query($query_view, $conn) or die(mysql_error());
$row_view = mysql_fetch_assoc($view);
$totalRows_view = mysql_num_rows($view);

if($row_view){
  $submit="Y";}
  else{
  $submit="N";}

  
//檢查第一次上傳或更新
mysql_select_db($database_conn, $conn);
$query_view = sprintf("SELECT * FROM receipt WHERE memberid = '" . $_SESSION['MM_Username'] ."'", $colname_view);
$view = mysql_query($query_view, $conn) or die(mysql_error());
$row_view = mysql_fetch_assoc($view);
$totalRows_view = mysql_num_rows($view);

if($row_view) //更新
 {
  $SQL = "UPDATE receipt SET contact=".GetSQLValueString($_POST['contact'], "text"). " ,email=".GetSQLValueString($_POST['email'], "text")." ,memo=".GetSQLValueString($_POST['memo'], "text")." ,uploadtime=".GetSQLValueString(date("Y/m/d h:i:s"), "text")." where memberid='".$_SESSION['MM_Username']."'";
  //刪除上次檔案$path line80
        unlink($path[0]);
  }
  else{ //新增
    $SQL = sprintf("INSERT INTO receipt (memberid,paper,contact,email,memo,uploadtime) VALUES (%s, %s, %s, %s,  %s, %s)",
                       GetSQLValueString($_POST['memberid'], "text"),
                       GetSQLValueString($submit, "text"),
                       GetSQLValueString($_POST['contact'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
					   GetSQLValueString($_POST['memo'], "text"),
                       GetSQLValueString(date("Y/m/d h:i:s"), "text"));
  }
  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($SQL, $conn) or die(mysql_error());
 }
 }
?>

<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>報名繳費收據上傳</title>
<style type="text/css">
<!--
.format {
	border: 2px inset;
	width: 236px;
	height: 22px;
	background-color: #FFFFFF;
	font-size: 13px;
	padding: 1px;
}
.style1 {color: #FF0000}
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
	Contactlabel.style.color="#000000";
	Emaillabel.style.color="#000000";

	if(!which.Contact.value){
		Contactlabel.style.color="#FF0000";
		valid=false;
	}
	if(!Emailrxp.exec(which.Email.value)){
		Emaillabel.style.color="#FF0000";
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

<table width=100% border=0 cellspacing=10>
        <th bgcolor="#FFFFFF" class="topic">報名繳費收據上傳</th>
  <tr>
	<td class="content"><br>
<?php
if(isset($msg) && $msg!='') {
  echo "<b>$msg</b><br>";
}
else {
  if(isset($success)) {
    echo "<div align=\"center\">".$success.$path[0]."</div></td></tr></table></DIV></body></html>";
    exit;
  }
}
?>


<?php 
//查詢繳費狀態
mysql_select_db($database_conn, $conn);
$query_view = sprintf("SELECT * FROM receipt WHERE memberid = '" . $_SESSION['MM_Username'] ."'", $colname_view);
$view = mysql_query($query_view, $conn) or die(mysql_error());
$row_view = mysql_fetch_assoc($view);
$totalRows_view = mysql_num_rows($view);


if($row_view) 
  {
   $paid="已於".$row_view['uploadtime']."上傳收據";
   if($row_view['Confirmed'] == "Y")
   $Confirmed ="<font color=#FF0000><b>帳款已收到</b></font>";
   else
   $Confirmed ="<b>帳款確認中</b>";
  }
  else
  {
  $paid="尚未上傳收據";
  $Confirmed="無資料";
  }
?>
      <form action="<?php echo $editFormAction; ?>" method="POST" enctype="multipart/form-data" name="upload" id="upload">
	  <table width=85% border=0 align="center" cellpadding=5 cellspacing=1 class=forumline>
        <tr class="color">
          <td colspan=2><font>
            <?php print $_SESSION['MM_Username']; ?>
          </font>您好，請下載報名表後填寫以附檔方式上傳，並填寫相關資訊。(若需更正請重新填寫資料與上傳檔案)</td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content">繳費狀態<font size="2"> :</font></td>
          <td><?php echo $paid; ?></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content">帳款確認狀態</td>
          <td><?php echo $Confirmed; ?></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap bgcolor="#CCCCCC" class="content">&nbsp;</td>
          <td bgcolor="#CCCCCC">&nbsp;</td>
        </tr>
		
		
<?php //帳確認後就停用收據上傳功能
if($row_view['Confirmed'] == "N" || $row_view == false ){
?>		
		
        <tr class="content">
          <td width="13%" align="right" nowrap class="content"><font size="2">
            <label id="Topiclabel" for="Topic">您的帳號</label>
          :</font></td>
          <td width="83%"><font>
            <?PHP print $_SESSION['MM_Username']; ?>
			<input type="hidden" name="memberid" id="memberid" value=<?PHP echo $_SESSION['MM_Username']; ?>>
          </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content">已投稿篇名</td>
		  
		  <?php
		  //查詢投稿紀錄
mysql_select_db($database_conn, $conn);
$query_view = sprintf("SELECT * FROM upload WHERE Member = '" . $_SESSION['MM_Username'] ."'", $colname_view);
$view = mysql_query($query_view, $conn) or die(mysql_error());
$row_view = mysql_fetch_assoc($view);
$totalRows_view = mysql_num_rows($view);
		  ?>
		   
		  
          <td>
	   <?php 
	   if ($row_view)
	   do { ?>
 		  序號:<?php echo $row_view['Paper_serial']; ?>. <?php echo $row_view['Topic']; ?><br>
    	<?php } while ($row_view = mysql_fetch_assoc($view)); 
		else
		 echo "無投稿紀錄";
		?>		  </td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2">
            <label id="Contactlabel" for="Contact">聯絡人</label>:</font></td>
          <td><font>
            <input name="contact" type="text" id="contact" size="25">
          </font> </td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2">
            <label id="Emaillabel" for="Email">e-mail</label>:</font></td>
          <td><font>
            <input type="text" name="email" id="email" size="25">
          </font></td>
        </tr>
        <tr class="content">
          <td align="right" nowrap class="content"><font size="2">
            <label id="Faxlabel" for="Fax">備註</label>:</font></td>
          <td><font>
            <input name="memo" type="text" id="memo" size="50" maxlength="500">
          </font></td>
        </tr>
        
        <tr class="content">
          <td colspan="2" align=right class="content"><div align="left">
            <p><span class="style1">註1.未投稿者，欲參加研討會，每人費用為新台幣一千五百元整，請匯款/轉帳後，將收據貼於報名表上傳至系統。</span></p>
            <p><span class="style1">註2.同一作者投稿多篇論文，請依篇數繳費(每篇新台幣一千五百元整)，並分別填寫報名表，多張報名表請先壓縮成(*.rar或*.zip)後上傳，謝謝</span>。</p>
            <p class="style1">註3.<span class="style1">同一篇論文，有多位作者參與，若需參加研討會，請依人數繳費(每人新台幣一千五百元整)，並分別填寫報名表，多張報名表請先壓縮成(*.rar或*.zip)後上傳，謝謝</span>。</p>
          </div></td>
          </tr>
        <tr class="content">
          <td align=right class="content">報名表:</td>
          <td><input name="ulfile[]" type="file" size="25"></td>
        </tr>
        <tr class="content">
          <td></td>
          <td>            <input type="SUBMIT" VALUE="送出">              　
                <input type="RESET" VALUE="清除重填"></td></tr>
      </table>
      <input type="hidden" name="MM_insert" value="upload">
      </form>
	    <div align="right"><br>
	      <a href="logout.php" target="_top">登出</a></div></td>
  </tr>
<?php } //帳確認後就停用收據上傳功能 

else
echo "<tr><td><a href=logout.php target=_top>登出</a></td></tr>";
?>
</table>
</DIV></DIV>
</body>
</html>
