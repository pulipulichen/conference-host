<?php require_once('../../Connections/conn.php'); ?>

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
    <th class="topic">查詢使用者密碼</th>
<tr>
	<td height="137" class="content">
      <br>
      <form ACTION="forgot_send.php" method="POST" name="query_pw" id="query_pw">
	  <table width=85% border=0 align="center" cellpadding=5 cellspacing=1 class=forumline>
        <tr class="content">
          <td width="35%" align=right>請輸入E-mail帳號</td>
          <td colspan="2"><input type="text" name="em" maxlength="200" size="50"></td>
        </tr>
        <tr class="content">
          <td height="53">&nbsp;            </td>
          <td width="49%"><input type="SUBMIT" value="查詢密碼"></td>
          <td width="16%"><p>&nbsp;</p>            </td>
        </tr>
      </table>
	  
	  
      </form></td>
</tr>
</table>
</DIV></DIV>
</body>
</html>