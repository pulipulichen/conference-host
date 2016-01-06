<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Frameset//EN" "http://www.w3.org/TR/html4/frameset.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>管理介面</title>
</head>
<LINK REL="stylesheet" HREF="../style/style_adm.css" TYPE="text/css">

<?php
// 驗證管理者帳號以及密碼
$Pass = MD5($_POST['password']);
if ($_POST['username'] != 'cmchen' || $Pass != '9f76d7162de8feeaa9b1828744ef8a5e') {
echo <<<EOT
<form name = "login" method = "post" action = "index.php">
<table width="30%" border="1" align = "center" cellPadding = "2" cellSpacing = "0" borderColor = "#CCCCFF" bgcolor = "#FFFFFF" style = "border-collapse: collapse">
  <tr><td bgColor = "#CCCCFF" width = "100%"><font color = "#FFFFFF">◤ Login Interface</font></td></tr>
  <tr><td><div align = "center">
    <table border = "0" cellPadding = "2" cellSpacing = "0" width = "100%">
      <tr><td align = "right" width = "50%">AdminID : </td><td align = "left" width = "50%"><input name = "username" type = "text" id = "username" size = "15" maxlength = "50" class = "txt"></td></tr>
      <tr><td align = "right">Password : </td><td align = "left"><input name = "password" type = "password" id = "password" size = "16" maxlength = "50" class = "txt"></td></tr>
    </table>
    <br><input type = "submit" name = "Submit" value = "Login" class = "btm">
  </div></td></tr>
</table>
</form>
EOT;
}
else {
// 管理介面呈現
echo <<<EOT
<frameset rows="60,*" framespacing="1" border="1">
  <frame name="menu" src="menu.htm" scrolling="no" noresize>
  <frame name="main" src="referee.php">
</frameset>
<noframes><body>
</body></noframes>
EOT;
}
?>

</html>