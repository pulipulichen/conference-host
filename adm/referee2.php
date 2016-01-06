<?php require_once('../Connections/conn.php'); ?>
<?php
$colname_referee = "1";
if (isset($_GET['id'])) {
  $colname_referee = (get_magic_quotes_gpc()) ? $_GET['id'] : addslashes($_GET['id']);
}
mysql_select_db($database_conn, $conn);
$query_referee = sprintf("SELECT id, name, location, profession, distribute FROM referee WHERE id = '%s'", $colname_referee);
$referee = mysql_query($query_referee, $conn) or die(mysql_error());
$row_referee = mysql_fetch_assoc($referee);
$totalRows_referee = mysql_num_rows($referee);
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<meta http-equiv="pragma" content="no-cache">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>無標題文件</title>
<style type="text/css">
<!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
}
.style1 {font-size: 12px}
-->
</style>
</head>
<body>
      <div align="center">
        <?php if ($totalRows_referee == 0) { // Show if recordset empty ?>
	    未選取審稿者! 
	    <?php } // Show if recordset empty ?>
        <?php if ($totalRows_referee > 0) { // Show if recordset not empty ?>
</div>
      <table width="960"  border="1" align="center" cellpadding="2" cellspacing="0" bordercolor="#000000">
          <tr bgcolor="#666666">
            <td width="8%"><span class="style3 style1">帳號</span></td>
            <td width="5%"><span class="style1">組別</span></td>
            <td width="83%"><span class="style3 style1">專長</span></td>
            <td width="4%">分配</td>
          </tr>
          <?php do { ?>
          <tr bgcolor="#B9D1EA">
            <td><span class="style3 style1"><?php echo $row_referee['name']; ?></span></td>
            <td><span class="style3 style1"><?php if(!strcmp('local',$row_referee['location'])){echo '國內';}else{echo '國外';} ?></span></td>
            <td><span class="style3 style1"><?php echo $row_referee['profession']; ?></span></td>
            <td><span class="style3 style1"><?php echo $row_referee['distribute']; ?></span></td>
          </tr>
        <?php } while ($row_referee = mysql_fetch_assoc($referee)); ?>
</table>
	  <?php } ?>
</body>
</html>
<?php
mysql_free_result($referee);
?>