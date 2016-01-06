<?php require_once('../Connections/conn.php'); ?>
<?php
mysql_select_db($database_conn, $conn);
$query_send = "SELECT paper_serial, member, topic, `group`, email FROM upload ORDER BY paper_serial ASC";
$send = mysql_query($query_send, $conn) or die(mysql_error());
$row_send = mysql_fetch_assoc($send);
$totalRows_send = mysql_num_rows($send);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>無標題文件</title>
</head>

<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td>上傳編號</td>
    <td>帳號</td>
    <td>論文題目</td>
    <td>組別</td>
    <td>電子郵件</td>
    <td>寄信</td>
  </tr>
  <?php do { ?>
  <tr>
    <td><?php echo $row_send['paper_serial']; ?></td>
    <td><?php echo $row_send['member']; ?></td>
    <td>
        <div align="left">
            <?php echo $row_send['topic']; ?> 
            - 
            <a href="../upload/<?php echo $row_send['member']; ?>/abstract-<?php echo $row_send['paper_serial']; ?>.pdf" target="_blank">
                [摘要]
            </a> 
            / 
            <a href="../upload/<?php echo $row_send['member']; ?>/paper-<?php echo $row_send['Paper_serial']; ?>.pdf" target="_blank">
                [全文]
            </a>
        </div>
    </td>
    <td>口頭報告(oral)</td>
    <td><?php echo $row_send['email']; ?></td>
    <td><form name="form1" method="post" action="send.php">
        <input name="serial" type="hidden" value="<?php echo $row_send['paper_serial']; ?>">
        <input name="member" type="hidden" value="<?php echo $row_send['member']; ?>">
        <input name="topic" type="hidden" value="<?php echo $row_send['topic']; ?>">
        <input name="group" type="hidden" value="<?php echo $row_send['group']; ?>">
        <input name="email" type="hidden" value="<?php echo $row_send['email']; ?>">
        <input type="submit" name="Submit" value="送出">
          </form></td>
  </tr>
  <?php } while ($row_send = mysql_fetch_assoc($send)); ?>
</table>
</body>
</html>
<?php
//mysql_free_result($send);
