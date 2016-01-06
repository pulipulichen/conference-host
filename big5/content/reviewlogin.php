<?php require_once('../../Connections/conn.php'); ?>
<?php
// *** Validate request to login to this site.
session_start();

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {//$accesscheck)) {
  $GLOBALS['PrevUrl'] = $_GET['accesscheck'];//$accesscheck;
  session_register('PrevUrl');
}

if (isset($_POST['ID'])) {
  $loginUsername=$_POST['ID'];
  $password=$_POST['PW'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "./reviewlist.php";
  $MM_redirectLoginFailed = "./reviewlogin.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_conn, $conn);
  
  $LoginRS__query=sprintf("SELECT id, password FROM referee WHERE id='%s' AND password='%s'",
    get_magic_quotes_gpc() ? $loginUsername : addslashes($loginUsername), get_magic_quotes_gpc() ? $password : addslashes($password)); 
   
  $LoginRS = mysql_query($LoginRS__query, $conn) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
    //declare two session variables and assign them
    $GLOBALS['MM_Username'] = $loginUsername;
    $GLOBALS['MM_UserGroup'] = $loginStrGroup;	      

    //register the session variables
    session_register("MM_Username");
    session_register("MM_UserGroup");

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
	unset($_SESSION['PreUrl']);
	session_unregister('PreUrl');
    }
    header("Location: " . $MM_redirectLoginSuccess );
	exit;
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
	exit;
  }
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>登入使用者</title>
</head>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/menu.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/style.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../menuItems.js"></SCRIPT>
<LINK REL="stylesheet" HREF="../../style/style.css" TYPE="text/css">
<body onLoad="cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice')">
<DIV id="myMenuID"></DIV>
<br><DIV class="scoll">
<table width=100% border=0 cellspacing=10>
    <th class="topic">審稿者登入</th>
<tr>
	<td class="content">
      <br>
      <form ACTION="<?php echo $loginFormAction; ?>" method="POST" name="register" id="register">
	  <table width=85% border=0 align="center" cellpadding=5 cellspacing=1 class=forumline>
        <tr class="content">
          <td width="35%" align=right>帳號</td>
          <td><input type="text" name="ID" maxlength="100" size="16"></td>
        </tr>
        <tr class="content">
          <td align=right>密碼</td>
          <td><input type="password" name="PW" maxlength="50" size="16"></td>
        </tr>
        <tr class="content">
          <td>&nbsp;            </td>
          <td><input type="SUBMIT" value="送出"></td>
          </tr>
      </table>
      </form></td>
</tr>
</table>
</DIV></DIV>
</body>
</html>