<?php require_once('../../Connections/conn.php'); ?>
<meta http-equiv="Content-Type" content="text/html; charset=BIG-5">
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/menu.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../../scripts/style.js"></SCRIPT>
<SCRIPT LANGUAGE="JavaScript" SRC="../menuItems.js"></SCRIPT>
<LINK REL="stylesheet" HREF="../../style/style.css" TYPE="text/css">
<body onLoad="cmDraw ('myMenuID', myMenu, 'hbr', cmThemeOffice, 'ThemeOffice')">
<DIV id="myMenuID"></DIV>
<br><DIV class="scoll">

<?php

mysql_select_db($database_conn, $conn);
$query_em = sprintf("SELECT name,id,pw,email FROM member WHERE email = '".$_POST['em']."'");
$em = mysql_query($query_em, $conn) or die(mysql_error());
$row_em = mysql_fetch_assoc($em);
$totalRows_em = mysql_num_rows($em);


$mailto = $_POST['em'];
$mailfrom = 'From:csclcspl2013@gmail.com';

  $content = stripcslashes($row_em['name']) . "您好:\n\n" .
               "您所查詢的帳號及密碼如下：\n\n" .
               "帳號:".$row_em['id']."\n" .
               "密碼:".$row_em['pw']."\n\n" .
			   "請由此連結 http://csclcspl2013.dlll.nccu.edu.tw 重新登入\n" .
			   "若您後續有任何問題，請與我們聯繫E-mail: csclcspl2013@gmail.com ，謝謝。\n" .
			   "2013年第二屆數位合作學習與個人化學習研討會 敬上";
  $subject = "2013年第二屆數位合作學習與個人化學習研討會會員資料查詢";
  $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";
  //$subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

    mail($mailto, $subject, $content, $mailfrom);
    //printf(stripcslashes(iconv("Big-5","UTF-8","寄送成功!!")));
	printf("\n\n\n<center>帳號密碼已寄送至".$_POST['em']."</center>");
?>
