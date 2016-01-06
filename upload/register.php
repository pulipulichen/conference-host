<?php require_once('../../Connections/conn.php'); ?>
<?php
// *** Redirect if username exists
$MM_flag="MM_insert";
if (isset($_POST[$MM_flag])) {
  //$MM_dupKeyRedirect="register.php";
  $loginUsername = $_POST['ID'];
  $LoginRS__query = "SELECT id FROM member WHERE id='" . $loginUsername . "'";
  mysql_select_db($database_conn, $conn);
  $LoginRS=mysql_query($LoginRS__query, $conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);

  //if there is a row in the database, the username was found - can not add the requested username
  if($loginFoundUser){
    //$MM_qsChar = "?";
    //append the username to the redirect page
    //if (substr_count($MM_dupKeyRedirect,"?") >=1) $MM_qsChar = "&";
    //$MM_dupKeyRedirect = $MM_dupKeyRedirect . $MM_qsChar ."requsername=".$loginUsername;
    //header ("Location: $MM_dupKeyRedirect");
    //exit;
	if(!isset($wrongID)) {
	  $wrongID=true;
	}
  }
}

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

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "register") && !isset($wrongID)) {
  $insertSQL = sprintf("INSERT INTO member (name, id, pw, email, affiliation, `position`, phone, address, fax, city) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['id'], "text"),
                       GetSQLValueString($_POST['pw'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['affiliation'], "text"),
                       GetSQLValueString($_POST['position'], "text"),
                       GetSQLValueString($_POST['phone'], "text"),
                       GetSQLValueString($_POST['address'], "text"),
                       GetSQLValueString($_POST['fax'], "text"),
                       GetSQLValueString($_POST['city'], "text"));

  mysql_select_db($database_conn, $conn);
  $Result1 = mysql_query($insertSQL, $conn) or die(mysql_error());
  if($Result1){
  if(!isset($isSuccess)) {
    @mkdir("../../upload/$loginUsername");
    $isSuccess=true;
  }else {
  	$isSuccess=false;
  }
  }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>大會主旨與目的</title>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/menu.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/style.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../menuItems.js"></SCRIPT>
<script language="JavaScript">
<!--
function checkForm(which) {
	var valid=true;
	IDrxp=/^\w{1,32}$/;
	PWrxp=/^\S{6,32}$/;
	Namerxp=/^.{1,32}$/;
	Emailrxp=/^\S+@\S+\.\S{2,5}$/;
	PhoneFaxrxp=/^\(*\d{2,4}\)*-*\d{6,8}-*\d*$/;
	IDlabel.style.color="#000000";
	PWlabel.style.color="#000000";
	checkPWlabel.style.color="#000000";
	Namelabel.style.color="#000000";
	Emaillabel.style.color="#000000";
	Phonelabel.style.color="#000000";
	Faxlabel.style.color="#000000";
	if(!IDrxp.exec(which.ID.value)){
		IDlabel.style.color="#FF0000";
		valid=false;
	}
	if(!PWrxp.exec(which.PW.value)){
		PWlabel.style.color="#FF0000";
		valid=false;
	}
	if(!which.checkPW.value || which.checkPW.value!=which.PW.value){
		checkPWlabel.style.color="#FF0000";
		valid=false;
	}
	if(!Namerxp.exec(which.Name.value)){
		Namelabel.style.color="#FF0000";
		valid=false;
	}
	if(!Emailrxp.exec(which.Email.value)){
		Emaillabel.style.color="#FF0000";
		valid=false;
	}
	if(!PhoneFaxrxp.exec(which.Phone.value) && which.Phone.value){
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

<table width=100% border=0 cellspacing=10>
    <th class="topic">會員帳號申請</th>
  <tr>
	<td class="content"><br>
<?php
	if(isset($wrongID))
	  echo "<div align=\"center\">這個帳號已被使用，請輸入其他帳號申請。</div>";
	if(isset($isSuccess)) {if($isSuccess){
	  echo "<div align=\"center\">新增帳號成功!!<a href=\"login.php\">登入</a></div></td></tr></table></DIV></body></html>";exit;
	}else {
	  echo "<div align=\"center\">新增帳號失敗。請<a href=\"mailto:csclcspl2013@gmail.com\">聯絡我們</a>，或嘗試稍後申請。</div>";exit;
	}}
?>
	  <form action="<?php echo $editFormAction; ?>" method="POST" name="register" id="register" onSubmit="return checkForm(this)">
	  <table width=85% border=0 align="center" cellpadding=0 cellspacing=10 class=forumline>
        <tr class="color">
          <td colspan=2>以下為必須填寫的項目<span class="style1">*</span>。</td>
        </tr>
        <tr class="content">
          <td align=right><span class="style1">*</span><label id="IDlabel" for="ID">帳號</label></td>
          <td><input type="text" name="ID" maxlength="16" size="16"></td>
        </tr>
        <tr class="content">
          <td align=right><span class="style1">*</span><label id="PWlabel" for="PW">密碼</label></td>
          <td><input type="password" name="PW" maxlength="32" size="16">
    　密碼介於6到32個字元的英數字！</td>
        </tr>
        <tr class="content">
          <td align=right><span class="style1">*</span><label id="checkPWlabel" for="checkPW">確認密碼</label></td>
          <td><input name="checkPW" type="password" size="16" maxlength="32">
    　請再次確認密碼！</td>
        </tr>
        <tr class="content">
          <td align=right><span class="style1">*</span><label id="Namelabel" for="Name">姓名</label></td>
          <td><input type="text" name="Name"></td>
        </tr>
        <tr class="content">
          <td align=right><span class="style1">*</span><label id="Emaillabel" for="Email">電子信箱</label></td>
          <td><input type="text" name="Email"></td>
        </tr>
        <tr class="color">
          <td colspan=2>以下為選擇填寫的項目。</td>
        </tr>
        <tr class="content">
          <td align=right>服務單位</td>
          <td><input type="text" name="Affiliation"></td>
        </tr>
        <tr class="content">
          <td align=right>職稱</td>
          <td><input type="text" name="Position"></td>
        </tr>
        <tr class="content">
          <td align=right><label id="Phonelabel" for="Phone">聯絡電話</label></td>
          <td><input type="text" name="Phone"></td>
        </tr>
        <tr class="content">
          <td align=right><label id="Faxlabel" for="Fax">傳真號碼</label></td>
          <td><input type="text" name="Fax"></td>
        </tr>
        <tr class="content">
          <td align=right>聯絡地址</td>
          <td><select name="city" onChange="citychange()">
              <option value="" selected>請選擇縣市</option>
              <option value="基隆市">基隆市</option>
              <option value="台北市">台北市</option>
              <option value="新北市">新北市</option>
              <option value="桃園縣">桃園縣</option>
              <option value="新竹市">新竹市</option>
              <option value="新竹縣">新竹縣</option>
              <option value="苗栗縣">苗栗縣</option>
              <option value="台中市">台中市</option>
              <option value="彰化縣">彰化縣</option>
              <option value="南投縣">南投縣</option>
              <option value="雲林縣">雲林縣</option>
              <option value="嘉義市">嘉義市</option>
              <option value="嘉義縣">嘉義縣</option>
              <option value="台南市">台南市</option>
              <option value="高雄市">高雄市</option>
              <option value="屏東縣">屏東縣</option>
              <option value="台東縣">台東縣</option>
              <option value="花蓮縣">花蓮縣</option>
              <option value="宜蘭縣">宜蘭縣</option>
              <option value="澎湖縣">澎湖縣</option>
              <option value="金門縣">金門縣</option>
              <option value="連江縣">連江縣</option>
            </select>
              <input name="Address" type="text" size="32">
          </td>
        </tr>
        <tr class="content">
          <td></td>
          <td><input type="SUBMIT" VALUE="送出">
              <input type="RESET" VALUE="清除重填">
              <input name="MM_insert" type="hidden" id="MM_insert" value="register"></td>
        </tr>
      </table>
      </form>
	</td>
  </tr>
</table>
</DIV></DIV>
</body>
</html>
<?php
/*
Warning: mkdir() [function.mkdir]: File exists in C:\AppServ\www\web\big5\content\register.php on line 73
*/
?>