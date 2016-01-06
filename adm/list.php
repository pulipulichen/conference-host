<?php require_once('../Connections/conn.php'); ?>
<?php
mysql_select_db($database_conn, $conn);
$query_memberlist = "SELECT name, id, email, affiliation, phone, fax FROM member";
$memberlist = mysql_query($query_memberlist, $conn) or die(mysql_error());
$row_memberlist = mysql_fetch_assoc($memberlist);
$totalRows_memberlist = mysql_num_rows($memberlist);

?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>無標題文件</title>
</head>

<body>
<table width="100%"  border="1" cellpadding="0" cellspacing="0" bordercolor="#000000">
  <tr>
    <td>ID</td>
    <td>姓名</td>
    <td>服務單位</td>
    <td>電子郵件</td>
    <td>電話</td>
    <td>傳真</td>
    <td>投稿篇數</td>
  </tr>
  <?php do { ?>
  <tr>
    <td><?php echo $row_memberlist['id']; ?></td>
    <td><?php echo $row_memberlist['name']; ?></td>
    <td><?php echo $row_memberlist['affiliation']; ?>&nbsp;</td>
    <td><?php echo $row_memberlist['email']; ?>&nbsp;</td>
    <td><?php echo $row_memberlist['phone']; ?>&nbsp;</td>
    <td><?php echo $row_memberlist['fax']; ?>&nbsp;</td>
    <td><?php 
$query_paper = sprintf("SELECT * FROM upload WHERE member = '%s'", $row_memberlist['ID']);
$paper = mysql_query($query_paper, $conn) or die(mysql_error());
echo mysql_num_rows($paper);
?></td>
  </tr>
  <?php } while ($row_memberlist = mysql_fetch_assoc($memberlist)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($memberlist);

mysql_free_result($paper);