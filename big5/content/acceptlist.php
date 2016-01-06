<?php require_once('../../Connections/conn.php'); ?>
<?php
mysql_select_db($database_conn, $conn);
$query_paper = "SELECT Paper_serial, Topic FROM upload WHERE receive = 'a'";
$paper = mysql_query($query_paper, $conn) or die(mysql_error());
$row_paper = mysql_fetch_assoc($paper);
$totalRows_paper = mysql_num_rows($paper);
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
      <th class="topic">接受論文一覽表</th>
<tr>
	<td class="content">
      <br>
      <table width="100%"  border="1" cellpadding="2" cellspacing="0" bordercolor="#999999">
          <tr class="color">
              <td width="14%"><div align="center">論文編號</div></td>
              <td width="86%"><div align="center">論文標題</div></td>
          </tr>
          <?php 
		  $i=0;
		  do { 
          if(($i++)%2) echo '<tr bgcolor="#DDEEFF"';
		  else echo '<tr bgcolor="#FFFFFF"';
		  ?> class="content">
                  <td><?php echo $row_paper['Paper_serial']; ?></td>
                  <td><?php echo $row_paper['Topic']; ?></td>
          </tr>
          <?php } while ($row_paper = mysql_fetch_assoc($paper)); ?>
      </table>
      </td>
</tr>
</table>
</DIV></DIV>
</body>
</html>
<?php
mysql_free_result($paper);
?>
